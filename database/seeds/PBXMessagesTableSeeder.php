<?php

use App\Enums\PBXMessageType;
use Illuminate\Database\Seeder;

class PBXMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pbx_messages')->insert([
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'For English press 1, para Español presione el número dos. For training purposes this call may be recorded.'
            ],
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'You’ve reached “Company Name”. For Sales Press 1. For Customer Service press 2. For all other inquiries press 3 or wait in line for one of our operators.'
            ],
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'For Sales, Press 1. For Support, Press 2. For all other questions, press 3.'
            ],
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'If you know the extension of the person you would like to reach, you may dial it at any time. You can also press 0 to reach an agent. For all other callers, please listen to the following options: for account information press 1, for questions about a product you purchased press 2.'
            ],
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'If you know your party’s extension, you may dial it at any time. Otherwise, please choose from the following options: for customer support press 1, for sales press 2.'
            ],
            [
                'type' => PBXMessageType::BUSINESS,
                'message' => 'To reach our company directory, press 1. For more information about [Company Name], press 2. If you are an existing customer, please press 3. For billing questions, press 4. To repeat menu options, press 9. For all other inquiries, press 0.'
            ],
            [
                'type' => PBXMessageType::DOWNTIME,
                'message' => 'You have reached “Company Name” our business hours are 8 am to 5 pm.'
            ],
            [
                'type' => PBXMessageType::DOWNTIME,
                'message' => 'Hello! Thank you for calling "Company Name". Our offices are closed. We are open Monday to Friday from 8.30 a.m. to 1.30 p.m. and from 4.30 p.m. to 7.30 p.m. If you wish you can send a fax to the number *** or an email to ***. Thank you and goodbye for now!.'
            ],
            [
                'type' => PBXMessageType::ONHOLD,
                'message' => 'Our operators are all busy as to not keep you waiting too long, if you have called us from an identifiable user, you will be contacted by the first available operator. Thank you for calling and talk to you later!.'
            ]
        ]);
    }
}
