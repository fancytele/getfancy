<?php

namespace App\Services;

use App\FancyNumber;
use Illuminate\Http\JsonResponse;

class PhoneSystemService{

    /**
     * @param  $data
     * @return bool|string
     */
    public function createCustomer($data){

        $token = env('PHONE_SYSTEM_USERNAME').':'.env('PHONE_SYSTEM_PASSWORD');
        $credentials_token = base64_encode($token);

        $name = $data->first_name." ".$data->last_name;
        $body = array('data' => array('id' => $data->id, 'type' => 'customers', 'attributes' => array('name' => $name, 'language' => 'EN')));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://console.sandbox.phone.systems/api/rest/public/operator/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic ".$credentials_token,
                "content-type: application/vnd.api+json"
            ),
            CURLOPT_FAILONERROR=> true,
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {

            return response()->json(['error' => $error] , 409);
        }
        else{
            $customer_response= json_decode($response);
            $customer = FancyNumber::where('user_id','=', $data->id)->first();
            $customer->customer_id_phone_system = $customer_response->data->id;
            $customer->save();

            return $customer_response;
        }
    }

    /**
     * @param $data
     * @return JsonResponse|mixed
     */
    public function createCustomerSession($data)
    {
        $token = env('PHONE_SYSTEM_USERNAME').':'.env('PHONE_SYSTEM_PASSWORD');
        $credentials_token = base64_encode($token);

        $customer_id = FancyNumber::where('user_id','=',$data->id)->pluck('customer_id_phone_system')->first();

        $body = array('data' => array('type' => 'sessions', 'relationships' => array('customer' => array('data' => array('id' => $customer_id, 'type' => 'customers')))));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://console.sandbox.phone.systems/api/rest/public/operator/sessions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic ".$credentials_token,
                "content-type: application/vnd.api+json"
            ),
            CURLOPT_FAILONERROR=> true,
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return response()->json(['error' => $error] , 409);
        }
        else {
            $customer_response= json_decode($response);
            $customer = FancyNumber::where('user_id','=', $data->id)->first();
            $customer->dashboard_link_phone_system = $customer_response->data->attributes->uri;
            $customer->save();

            return $customer_response;
        }
    }
}
