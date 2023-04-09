<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class backofficeController extends Controller
{
    //
    public function show_dashboard(){
       return view('backoffice.pages.dashboard');
    }

    public function addnew_serviceUser(){
        
        return view('backoffice.pages.addnew_serviceUser');
    }   

    public function update_serviceUser(){
        
        return view('backoffice.pages.update_serviceUser');
    }   

    public function show_surveyFeedback_serviceUser(){
        // Insert everytime when date_posted is not null
        $insert= "insert into responsetable (userID, responseTypeID) 
                 select userID, 1 from serviceuserdetailstable WHERE
                 userID not in 
                 (select userID from responsetable  where date_posted  is null
                    and responseTypeID =1 )";
        $insertStatus=DB::insert($insert);    
        //** End of insert  */
        
        //** 1st get the ones with date posted */
        //** 2nd get the blank ones that do not have posted date as blank */
        $selectFeedback=" SELECT *  from responsetable
                         WHERE  month(date_posted)=month(now())  and year(date_posted)=year(now()) and responseTypeID=1
                        UNION
                           select *  from responsetable
                          where responseTypeID=1 and   date_posted is null and userID not in 
                            (select userID  from responsetable
                             WHERE  month(date_posted)=month(now())  and year(date_posted)=year(now()) and responseTypeID=1)";
        $responseStatus = DB::select($selectFeedback);
        $selectDetails="select * from serviceuserdetailstable";
        $usersDetails=DB::select ($selectDetails);
              
        return view('backoffice.pages.show_surveyFeedback_serviceUser',
              ['responseStatus' => $responseStatus, 'usersDetails'=> $usersDetails]);
    }
    
    private function get_serviceUser_details($userID){
         $user = DB::table("serviceuserdetailstable")
         ->select('*')
         ->where(['userID'=>$userID])
         ->get();
         return $user;   
    }
    private function get_feedbackResponses($userID, $unique_value, $responseTypeID){
        $resp = DB::table("responsetable")
        ->select('*')
        ->where(['userID'=>$userID, 'unique_value'=> $unique_value, 'responseTypeID'=>$responseTypeID ])
        ->get();
        return $resp;   
    }
    
    private function get_responseType($responseTypeID){
        $resp = DB::table("responsetypetable")
        ->select('*')
        ->where(['responseTypeID'=>$responseTypeID ])
        ->get();
        return $resp;
    }
    


    public function view_feedback(Request $req){
       
        $userID= $req->userID;
        $unique_value=$req->unique_value;
        $responseTypeID=$req->responseTypeID;
        
        $resp=$this->get_feedbackResponses($userID, $unique_value, $responseTypeID);
        $date_posted=$resp[0]->date_posted;
        $date_received=$resp[0]->date_received;
        $response=[];
        $quesName=[];
        $quesTypeID=[];
        $quesOptions=[];
        $fullName='';
        $companyName=$this->company_settings[0]->companyName;
        $responseType='';
        if ($resp){
            $response=$resp[0]->responses;
            $quesName=$resp[0]->quesName;
            $quesTypeID=$resp[0]->quesTypeID;
            $quesOptions=$resp[0]->quesOptions;
        }
        //Lets get the details
        if ($responseTypeID==1){
           //Get the service user name
           $user= $this->get_serviceUser_details($userID);
           if ($user){
                $fullName=$user[0]->title . ' ' . $user[0]->firstName . ' ' . $user[0]->lastName;
            }
        }
        //Response type
        $resp=$this->get_responseType($responseTypeID);
        $respType='';
        if ($resp){
            $respType=$resp[0]->responseType;
        }
         

                
        $result['fullName']=$fullName . "<br> ";
        $result['companyName']=$companyName; 
        $result['datePosted']=" Date Sent: " . $date_posted;
        $result['dateReceived']=" Date Received: " . $date_received;
        $result['response']=$response;
        $result['quesName']=$quesName;
        $result['quesTypeID']=$quesTypeID;
        $result['quesOptions']=$quesOptions;
        $result['respType']=' ' . $respType . '<br>';


        return response()->json($result); 
    }    


    
    public function show_compliments_serviceUser(){
        return view('backoffice.pages.show_compliments_serviceUser');
    }
    
    public function show_complaints_serviceUser(){
        return view('backoffice.pages.show_complaints_serviceUser');
    }


    



    public function build_serviceUserFeedback(){
       
        return view('backoffice.pages.build_serviceUserFeedback');
    }   

    public function build_employeeFeedback(){
        
        return view('backoffice.pages.build_employeeFeedback');
    }
    
    public function update_companyProfile(){
       
        return view('backoffice.pages.update_companyProfile');
    }

    




}
