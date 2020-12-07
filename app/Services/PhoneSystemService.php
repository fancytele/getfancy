<?php

namespace App\Services;

use App\FancyNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PhoneSystemService{

    /**
     * @param  $data
     * @return bool|string
     */
    public function createCustomer($data){

        $token = env('PHONE_SYSTEM_USERNAME').':'.env('PHONE_SYSTEM_PASSWORD');
        $credentials_token = base64_encode($token);

        $name = $data->first_name." ".$data->last_name;

        $did = FancyNumber::where('user_id' ,'=' , $data->id)->first();

        $body = array('data' => array('id' => $did->did_number, 'type' => 'customers', 'attributes' => array('name' => $name, 'language' => 'EN')));

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
            Log::info('Create Customer Error:'.$error);
            return response()->json(['error' => $error] , 409);
        }
        else{
            $customer_response= json_decode($response);
            $did->customer_id_phone_system = $customer_response->data->id;
            $did->save();
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

        $did = FancyNumber::where('user_id','=',$data->id)->first();

        $body = array('data' => array('type' => 'sessions', 'relationships' => array('customer' => array('data' => array('id' => $did->customer_id_phone_system, 'type' => 'customers')))));

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
            Log::info('Create Customer Session Error:'. $error);
            return response()->json(['error' => $error] , 401);
        }
        else {
            $customer_response= json_decode($response);
            $did->dashboard_link_phone_system = $customer_response->data->attributes->uri;
            $did->save();

            Log::info('Create Customer Session Response:'.$response);
            return response()->json(['response' => $customer_response] , 200);
        }
    }
}
