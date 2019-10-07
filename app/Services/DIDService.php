<?php

namespace App\Services;

use Didww\Configuration as DIDWWConfiguration;
use Didww\Credentials as DIDWWCredentials;
use Didww\Item\AvailableDid as DIDWWAvailableDID;
use Didww\Item\Country as DIDWWCountry;
use Didww\Item\DidReservation as DIDWWReservation;
use Didww\Item\Order as DIDWWOrder;
use Didww\Item\OrderItem\ReservationDid as DIDWWOrderReservation;
use Didww\Item\Region as DIDWWRegion;
use Illuminate\Support\Facades\Auth;
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
     * The DID API Url
     *
     * @var string
     */
    private $apiUrl;

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

        return $countries->first();
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
     * Availables DID by Region Id
     * 
     * @param string $region A DIDWW region UUID
     * @return array
     */
    public function getAvailableDIDsByRegion(string $region)
    {
        $did_availables = DIDWWAvailableDID::all(['filter' => ['region.id' => $region]]);

        $result = $did_availables->getData();

        if ($result->isEmpty()) {
            return [];
        }

        return $result->toJsonApiArray();
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


    public function purchaseReservation(string $reservation)
    {
        $did_reservation = DIDWWReservation::find($reservation)->getData();

        $orderItem = new DIDWWOrderReservation();
        $orderItem->setDidReservationId($did_reservation->getId());

        $order = new DIDWWOrder();
        $items = [$orderItem];

        $order->setItems($items);
        $orderDocument = $order->save();
        $order = $orderDocument->getData();

        return $order->toJsonApiArray();
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
