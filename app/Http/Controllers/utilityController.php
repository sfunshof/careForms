<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Exception\GuzzleException;
//use GuzzleHttp\Client;

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
        ->setUsername(config('care.click_send_username'))
        ->setPassword(config('care.click_send_password'));

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
               $result = $apiInstance->smsSendPost($sms_messages);
            
            //print_r($result);
            return 1;
        } catch (Exception $e) {
            echo 'Exception when calling AccountApi->accountGet: ', $e->getMessage(), PHP_EOL;
            return -1;
        }
    }

    public function user_sendSMS(Request $req){
        //var_dump("hello");
        $company_setting=$this->company_settings[0];
        $from =$company_setting->smsName;
        $to=$req->tel;
        $userID=$req->userID;
        $statusID=$req->statusID;
        $responseTypeID=$req->responseTypeID;
        $date_of_interest=$req->date_of_interest;

        //if it is the first time, statusID==1 we need to generate a unique ID
        $unique_value=substr(md5(uniqid(rand(), true)),0,7);
        $sentCount=0;
        if ($statusID==2){ //2nd time please check if thius is 1st 2nd time 
            $resp = DB::table("responsetable")
            ->select('unique_value', 'sentCount')
            ->whereNull('date_received')  
            ->where(['userID'=>$userID, 'responseTypeID' =>$responseTypeID])
            ->get();
            if (count($resp)){
               $unique_value=$resp[0]->unique_value; 
               $sentCount=$resp[0]->sentCount;
            }
        }
        $smsPreText="";
        if  ($responseTypeID==1){
            $smsPreText=$company_setting->surveyServiceUserText;
        }
       
        $msg= $smsPreText  . " %0a " . url( '/' . $unique_value);
              
        //If this is the first time or a first resend  send it already
        //done at the clients
        $ok_to_send=1;
        if (($sentCount==2) && ($statusID==2)){
            $ok_to_send=0;
        }
        if ($ok_to_send==1){
            $result=$this->send_smsMsg($from,$to,$msg);
            //On success delivery the table should be updated
            if (($result==1)&& ($statusID==1)) { //1st time
                $q=DB::table('responsetable')
                    ->where([
                        ['userID', $userID],
                        ['responseTypeID', 1]
                    ])
                ->whereNull('date_posted')
                ->whereNull('date_received')        
                ->update([
                    'date_posted' => Carbon::now(),
                    'sentCount' => 1,
                    'date_of_interest' =>$date_of_interest,
                    'unique_value' => $unique_value
                ]);
            }elseif (($result==1)&& ($statusID==2)) { //snd time res-send
                $q=DB::table('responsetable')
                ->where([
                        ['userID', $userID],
                        ['responseTypeID', 1]
                    ])
                ->whereNull('date_received')    
                ->whereIn('sentCount', [1,2])    
                ->update([
                    'date_posted' => Carbon::now(),
                    'sentCount' => 2
                ]);
            }
            return response()->json($result); 
        }
    }
    public function serviceUser_viewResponse(Request $req){
        print_r($req);
        return 0;
    }

    
}
