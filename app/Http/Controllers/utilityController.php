<?php

namespace App\Http\Controllers;


use ClickSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class utilityController extends Controller
{
    //
    public function send_smsMsg($from,$to,$msgX){
        // Configure HTTP basic authorization: BasicAuth
        $config = ClickSend\Configuration::getDefaultConfiguration()
        ->setUsername('funayofol@yahoo.com')
        ->setPassword('DCFBF246-B74A-4547-6655-80D603343ADF');

        $apiInstance = new ClickSend\Api\SMSApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new \GuzzleHttp\Client(),
            $config
        );
        
        $msg = new \ClickSend\Model\SmsMessage();
        $msg->setFrom($from);
        $msg->setBody($msgX);
        $msg->setTo($to);
        $msg->setSource("sdk");
        $sms_messages = new \ClickSend\Model\SmsMessageCollection();
        $sms_messages->setMessages([$msg]);

        try {
            //$result = $apiInstance->smsSendPost($sms_messages);
            //print_r($result);
            return 1;
        } catch (Exception $e) {
            echo 'Exception when calling AccountApi->accountGet: ', $e->getMessage(), PHP_EOL;
            return -1;
        }
    }

    public function serviceuser_sendSMS(Request $req){
       //var_dump("hello");
       $company_setting=$this->company_settings[0];
       $from =$company_setting->smsName;
       $to=$req->tel;
       $uniqueNo=$req->uniqueNo;
       $userID=$req->userID;
       $statusID=$req->statusID;
       $msg=$company_setting->surveyServiceUserText . " %0a " . url('/' . $uniqueNo . '/' . $userID);
       $result=$this->send_smsMsg($from,$to,$msg);
       //On success delivery the table should be updated
       
       if (($result==1)&& ($statusID==1)) { //1st time
            $q=DB::table('responsetable')
            ->where([
                    ['date_posted', NULL],
                    ['date_received', NULL],
                    ['userID', $userID],
                    ['responseTypeID', 1]
                    ])
            ->update([
                'date_posted' => Carbon::now(),
                'sentCount' => 1
            ]);
        }elseif (($result==1)&& ($statusID==2))  { //snd time res-send
            $q=DB::table('responsetable')
            ->where([
                    ['date_received', NULL],
                    ['userID', $userID],
                    ['responseTypeID', 1]
                ])
            ->whereIn('sentCount', [1,2])    
            ->update([
                'date_posted' => Carbon::now(),
                'sentCount' => 2
            ]);
        }


       return response()->json($result); 
    }
    public function serviceUser_viewResponse(Request $req){
        print_r($req);
        return 0;
    }

    
}
