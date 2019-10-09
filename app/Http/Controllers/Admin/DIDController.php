<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DIDService;

class DIDController extends Controller
{
    /**
     * @var \App\Services\DIDService
     */
    private $didService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DIDService $didService)
    {
        $this->middleware(['auth', 'role:admin|agent']);
        $this->didService = $didService;
    }

    /**
     * Get a list of Cities by Region
     *
     * @param string $region
     * @return \Illuminate\Http\Response
     */
    public function getCitiesByRegion(string $region)
    {
        $cities = $this->didService->getCitiesByRegion($region);

        return response()->json($cities);
    }

    /**
     * Get a list of Availables DIDs
     *
     * @param string $city
     * @return \Illuminate\Http\Response
     */
    public function getAvailableDIDsByCity(string $city)
    {
        $dids = $this->didService->getAvailableDIDsByCity($city);

        return response()->json($dids);
    }

    /**
     * Reserve a given available DID
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReservation(Request $request)
    {
        $reservation = $this->didService->createReservation($request->input('did'));

        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroyReservation(string $reservation)
    {
        $result = $this->didService->destroyReservation($reservation);

        return response()->json(['success' => $result]);
    }
}
