<?php

namespace App\Services;

use App\Enums\DIDCDRStatus;
use Carbon\Carbon;
use Didww\Configuration as DIDWWConfiguration;
use Didww\Credentials as DIDWWCredentials;
use Didww\Item\AvailableDid as DIDWWAvailableDID;
use Didww\Item\CdrExport as DIDWWCDRExport;
use Didww\Item\City as DIDWWCity;
use Didww\Item\Country as DIDWWCountry;
use Didww\Item\Did as DIDWW;
use Didww\Item\DidReservation as DIDWWReservation;
use Didww\Item\Order as DIDWWOrder;
use Didww\Item\OrderItem\ReservationDid as DIDWWOrderItemReservation;
use Didww\Item\OrderItem\AvailableDid as DIDWWOrderItemAvailable;
use Didww\Item\Region as DIDWWRegion;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DIDService
{
    /**
     * The DID API key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * The DID Environment
     * 
     * @var string
     */
    private $env;

    /**
     * Const to get Stock Keeping Units with amount of channel
     * 
     */
    private const AMOUNT_CHANNEL_DEFAULT = 0;

    /**
     * Amount of attemps to get CDR report
     */
    private const CDR_MAX_TIMES = 2000;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $credentials = new DIDWWCredentials($this->getApiKey(), $this->getEnv());

        DIDWWConfiguration::configure($credentials);
    }

    /**
     * Get DIDWW Country
     *
     * @param string $iso Standard ISO 3166
     * @return Didww\Item\Country
     */
    public function getCountryByISO(string $iso)
    {
        log::info('ISO From Request ' . $iso);

        $did_countries = DIDWWCountry::all(['filter' => ['iso' => $iso]]);
        $countries = $did_countries->getData();

        log::info('Country selected from didww ' . json_encode($countries));

        abort_if($countries[0]->iso != 'US' , Response::HTTP_UNAUTHORIZED);

        abort_if($countries->isEmpty(), Response::HTTP_INTERNAL_SERVER_ERROR);

        return $countries->first()->toJsonApiArray();
    }

    /**
     * DIDWW Regions by Country Id
     *
     * @param string $country
     * @return array
     */
    public function getRegionsByCountry(string $country)
    {
        log::info('Country ID for US'. $country);

        $did_regions = DIDWWRegion::all(['filter' => ['country.id' => $country]]);

        $region = $did_regions->getData()->map(function ($item) {
            return [
                'id' => $item->getId(),
                'text' => $item->getName()
            ];
        });

        log::info('Regions filtered on this basis of country' . json_encode($region));

        return $region;
    }

    /**
     * DIDWW Citires by Region Id
     *
     * @param string $region
     * @return array
     */
    public function getCitiesByRegion(string $region)
    {
        log::info('Selected Region ID' . $region);

        $did_cities = DIDWWCity::all([
            'filter' => [
                'region.id' => $region,
                'is_available' => true
            ]
        ]);


        $city= $did_cities->getData()->map(function ($item) {
            return [
                'id' => $item->getId(),
                'text' => $item->name
            ];
        });

        log::info('City filtered on this basis of region' . json_encode($city));

        return $city;
    }

    /**
     * Availables DID by City Id
     * 
     * @param string $city A DIDWW region UUID
     * @return array
     */
    public function getAvailableDIDsByCity(string $city)
    {
        log::info('Selected City ID' . $city);

        if(!is_null($city)){
            $did_availables = DIDWWAvailableDID::all(['filter' => ['city.id' => $city]]);

            $result = $did_availables->getData();

            if (is_null($result)) {
                return [];
            }

            log::info('Available DIDs on the basis of the selected city' . json_encode($result));

            return $result->toJsonApiArray();
        }
        else{
            return [];
        }

    }

    public function getPurchasedDID(string $order_id)
    {
        $did = DIDWW::all(['filter' => ['order.id' => $order_id]]);

        $result = $did->getData();

        if ($result->isEmpty()) {
            return [];
        }

        return $result->first()->toJsonApiArray();
    }

    /**
     * Generate a DID reservation
     *
     * @param string $did A DIDWWW UUID
     * @return array
     */
    public function createReservation(string $did)
    {
        log::info('Create Reservation' . $did);

        $available_did = DIDWWAvailableDID::find($did)->getData();

        log::info('Available DID' .json_encode($available_did));

        $didReservation = new DIDWWReservation();
        $didReservation->setAvailableDid($available_did);
        $didReservation->setDescription('Reserved for potencial Fancyy client by user: ' . Auth::user()->email);

        $didReservation = $didReservation->save()->getData();

        log::info('Did Reservation' .json_encode($didReservation));

        return $didReservation->toJsonApiArray();
    }

    /**
     * Destroy a DID Reservation
     *
     * @param string $reservation A DIDWW reservation UUID
     * @return boolean
     */
    public function destroyReservation(string $reservation)
    {
        $available_reservation = DIDWWReservation::find($reservation)->getData();

        if (!$available_reservation) {
            return false;
        }

        $available_reservation->delete();

        return true;
    }

    /**
     * Purchase a given DID Reservation
     *
     * @param string $reservation A DID reservation UUID 
     */
    public function purchaseReservation(string $reservation, string $number)
    {
        log::info('Reservation' . $reservation);
        log::info('Number' . $number);

        $did_reservation = DIDWWReservation::find($reservation, [
            'include' => 'available_did.did_group.stock_keeping_units'
        ])->getData();

        log::info('DID Reservation' .json_encode($did_reservation));

        throw_unless($did_reservation, new Exception('DID is no longer available'));

        $did_available = $did_reservation->availableDID();

        log::info('DID Available' .json_encode($did_available));

        $did_group = $did_available->getIncluded()->didGroup();

        log::info('DID Group' .json_encode($did_group));

        return $this->purchaseDID($did_reservation->getId(), $number, $did_group, true);
    }

    /**
     * @param string $did
     */
    public function purchaseAvailableDID(string $did)
    {
        $available_did = $this->getAvailableDID($did);

        $did_group = $available_did->didGroup();
        return $this->purchaseDID($available_did->getId(), $available_did->getNumber(), $did_group);
    }


    public function getCallLogs(string $did)
    {
        $cdr_export = new DIDWWCDRExport();
        return $cdr_export->setFilerDidNumber($did);

    }

    public function getCDRReport(string $did, int $year, int $month)
    {
        $cache_key = base64_encode($did.$month.$year);

        if (Cache::has($cache_key)) {

            log::info('cache_key'. $cache_key);

            return Cache::get($cache_key);
        }

        else{
            // generate cdr export
            $cdr_export = new DIDWWCDRExport();
            $cdr_export->setFilerDidNumber($did);
            $cdr_export->setFilterYear($year);
            $cdr_export->setFilterMonth($month);

            $cdr_export_document = $cdr_export->save();
            $data = $cdr_export_document->getData();

            log::info('data' . json_encode($data));

            $id = $data->getId();


            // Get CSV file URL
            $find_cdr = null;
            $times = 0;

            try {
                do {
                    $cdr_export_document = DIDWWCDRExport::find($id);
                    $find_cdr = $cdr_export_document->getData();
                    $times += 1;
                } while (optional($find_cdr)->status !== DIDCDRStatus::COMPLETED && $times <= self::CDR_MAX_TIMES);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return [];
            }

            $file_name = $id . '.csv';

            if ($find_cdr->download(Storage::path($file_name))) {
                $lines = explode("\n", Storage::get($file_name));
                $headers = str_getcsv(array_shift($lines));

                if (empty($lines[0])) {

                    log::info('line[0] is empty');

                    Cache::put($cache_key, [] , now()->addMinutes(5));

                    return [];
                }

                $data = [];

                foreach ($lines as $line) {
                    $row = [];

                    foreach (str_getcsv($line) as $key => $field) {
                        if ($headers[$key] == 'Date/Time (UTC)') {
                            $date = new Carbon($field);
                            $row['Date'] = $date->toDateString();
                            $row['Time'] = $date->toTimeString();
                        } else {

                            $row[$headers[$key]] = $field;
                        }
                    }

                    if (!empty($line)) {
                        $row = array_filter($row);
                        $data[] = $row;
                    }
                }

                Cache::put($cache_key, $data, now()->addMinutes(10));

                log::info('fetch from original data');

                Storage::delete($file_name);

                return $data;
            }

            return [];
        }
    }

    /**
     * Get default Stock Keeping Unit (SKU)
     *
     * @param $did
     * @param $did_group
     * @return \Didww\Item\StockKeepingUnit
     */
    private function getDefaultStockKeepingUnit($did_group)
    {
        $skus = $did_group->getIncluded()->stockKeepingUnits;

        $sku = $skus->where('channels_included_count', $this::AMOUNT_CHANNEL_DEFAULT)->first();

        return $sku ? $sku : $skus->first();
    }

    /**
     * Get given DID or return random available DID
     * 
     * @param string $did
     * @return DIDWWAvailableDID
     */
    private function getAvailableDID(string $did)
    {
        if (!empty($did)) {
            return DIDWWAvailableDID::find($did, [
                'include' => 'did_group.stock_keeping_units'
            ])->getData();
        }

        $available_dids = DIDWWAvailableDID::all([
            'include' => 'did_group.stock_keeping_units',
        ]);

        $dids = $available_dids->getData()->all();

        return $dids[array_rand($dids)];
    }

    /**
     * @param string $available_did
     * @param string $number
     * @param $did_group
     * @param bool $is_reservation
     */
    private function purchaseDID(string $id, string $number, $did_group, bool $is_reservation = false)
    {
        $sku = $this->getDefaultStockKeepingUnit($did_group);

        log::info('SKU' .json_encode($sku));

        $order_item = null;

        if ($is_reservation) {
            $order_item = new DIDWWOrderItemReservation();
            $order_item->setDidReservationId($id);
        } else {
            $order_item = new DIDWWOrderItemAvailable();
            $order_item->setAvailableDidId($id);
        }

        $order_item->setSku($sku);

        $order = new DIDWWOrder();
        $order->setItems([$order_item]);

        $order_document = $order->save();

        $order = $order_document->getData();

        log::info('Order Details' .json_encode($order));

        $item = $order->getItems()[0];

        return [
            'id' => $order->getId(),
            'number' => $number,
            'amount' => $order->amount,
            'status' => $order->status,
            'created_at' => $order->created_at,
            'description' => $order->description,
            'reference' => $order->reference,
            'item' => [
                'qty' => $item->getQty(),
                'nrc' => $item->getNrc(),
                'mrc' => $item->getMrc(),
                'prorated_mrc' => $item->getProratedMrc(),
                'billed_from' => $item->getBilledFrom(),
                'billed_to' => $item->getBilledTo(),
                'did_group_id' => $item->getDidGroupId()
            ]
        ];
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        if ($this->apiKey) {
            return $this->apiKey;
        }

        $this->apiKey = config('services.didww.key');
        return $this->apiKey;
    }

    /**
     * @return string
     */
    private function getEnv()
    {
        if ($this->env) {
            return $this->env;
        }

        $this->env = config('services.didww.env');
        return $this->env;
    }

}
