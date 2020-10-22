<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PhoneSystemService;
use Illuminate\Http\Request;

class PhoneSystemController extends Controller
{
    public function createCustomer(){

        $service = new PhoneSystemService();

        $response = $service->createCustomer();

        return response()->json($response);
    }

    public function createCustomerSession(){
        $service = new PhoneSystemService();

        $response = $service->createCustomerSession();

        return response()->json($response);
    }


}
