<?php

namespace App\Services;

use App\Enums\DIDCDRStatus;
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
use Didww\Item\Region as DIDWWRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DIDService
{
    const CDR_MAX_TIMES = 200;

    /**
     * The DID API key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Const to get Stock Keeping Units with amount of channel
     * 
     */
    private const AMOUNT_CHANNEL_DEFAULT = 0;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $credentials = new DIDWWCredentials($this->getApiKey(), 'production');

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
        $did_countries = DIDWWCountry::all(['filter' => ['iso' => $iso]]);
        $countries = $did_countries->getData();

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
        $did_regions = DIDWWRegion::all(['filter' => ['country.id' => $country]]);

        return $did_regions->getData()->map(function ($item) {
            return [
                'id' => $item->getId(),
                'text' => $item->getName()
            ];
        });
    }

    /**
     * DIDWW Citires by Region Id
     *
     * @param string $region
     * @return array
     */
    public function getCitiesByRegion(string $region)
    {
        $did_cities = DIDWWCity::all([
            'filter' => [
                'region.id' => $region,
                'is_available' => true
            ]
        ]);

        return $did_cities->getData()->map(function ($item) {
            return [
                'id' => $item->getId(),
                'text' => $item->name
            ];
        });
    }

    /**
     * Availables DID by City Id
     * 
     * @param string $city A DIDWW region UUID
     * @return array
     */
    public function getAvailableDIDsByCity(string $city)
    {
        $did_availables = DIDWWAvailableDID::all(['filter' => ['city.id' => $city]]);

        $result = $did_availables->getData();

        if ($result->isEmpty()) {
            return [];
        }

        return $result->toJsonApiArray();
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
        $available_did = DIDWWAvailableDID::find($did)->getData();

        $didReservation = new DIDWWReservation();
        $didReservation->setAvailableDid($available_did);
        $didReservation->setDescription('Reserved for potencial Fancy client by user: ' . Auth::user()->email);

        $didReservation = $didReservation->save()->getData();

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
        $available_reservation->delete();

        return true;
    }

    /**
     * Purchase a given DID Reservation
     *
     * @param string $reservation A DID reservation UUID 
     */
    public function purchaseReservation(string $reservation)
    {
        $did_reservation = DIDWWReservation::find($reservation, [
            'include' => 'available_did.did_group.stock_keeping_units'
        ])->getData();

        $sku = $this->getDefaultStockKeepingUnit($did_reservation->availableDID());

        $orderItem = new DIDWWOrderItemReservation();
        $orderItem->setDidReservationId($did_reservation->getId());
        $orderItem->setSku($sku);

        $order = new DIDWWOrder();
        $order->setItems([$orderItem]);

        $orderDocument = $order->save();

        $order = $orderDocument->getData();
        $item = $order->getItems()[0];

        return [
            'id' => $order->getId(),
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

    public function getCDRReport(string $did, int $year, int $month)
    {
        // generate cdr export
        $cdr_export = new DIDWWCDRExport();
        $cdr_export->setFilerDidNumber($did);
        $cdr_export->setFilterYear($year);
        $cdr_export->setFilterMonth($month);

        $cdr_export_document = $cdr_export->save();
        $data = $cdr_export_document->getData();
        $id = $data->getId();

        // Get CSV file URL
        $find_cdr = null;
        $times = 0;

        do {
            $cdr_export_document = DIDWWCDRExport::find($id);
            $find_cdr = $cdr_export_document->getData();
            $times += 1;
        } while ($find_cdr->status !== DIDCDRStatus::COMPLETED && $times <= self::CDR_MAX_TIMES);

        $file_name = $id . '.csv';

        if ($find_cdr->download(Storage::path($file_name))) {
            $lines = explode("\n", Storage::get($file_name));
            $headers = str_getcsv(array_shift($lines));

            if (empty($lines[0])) {
                return [];
            }
            
            $data = [];

            foreach ($lines as $line) {
                $row = [];

                foreach (str_getcsv($line) as $key => $field) {
                    $row[$headers[$key]] = $field;
                }

                $row = array_filter($row);
                $data[] = $row;
            }

            Storage::delete($file_name);
            return $data;
        }

        return [];
    }

    /**
     * Get default Stock Keeping Unit (SKU)
     *
     * @param $did
     * @return \Didww\Item\StockKeepingUnit
     */
    private function getDefaultStockKeepingUnit($did)
    {
        $did_group = $did->getIncluded()->didGroup();
        $skus = $did_group->getIncluded()->stockKeepingUnits;

        $sku = $skus->where('channels_included_count', $this::AMOUNT_CHANNEL_DEFAULT)->first();

        return $sku ? $sku : $skus->first();
    }

    /**
     * Get the DID API key.
     *
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
}
