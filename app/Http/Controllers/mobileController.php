<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class mobileController extends Controller
{
    //
    public function index(Request $request){
        //get the service user details
        $userID = $request->id;
        $uniqueNo=$request->uniqueNo;
        $responseTypeID=$request->responseTypeID; //s=1 serviceU
        
        // This is for survey for service users/
        //blank company details
        View::share('mobile_companyName', '');
        $unknown="Unknown Campaign";

        //Get the user details 
        if ($responseTypeID==1){
            $userTable="serviceuserdetailstable";
            $userType="ServiceUser";
            $quesFormTable="serviceuserformtable";
            $quesFormPage="mobile.pages.serviceUserHome";
        }else{ //last point of call responseType not defined as 1,2,3,4,5,6
            return view('mobile.pages.userNotFound', ['userType' =>'User', 'username'=>'','campaign' => $unknown] );
        }  
        //ResponseTypeID is valid; what is the csmpaign name
        $resp = DB::table("responsetypetable")
            ->select('*')
            ->where(['responseTypeiD'=>$responseTypeID])
            ->get();
        if (count($resp)) {
            $campaign=$resp[0]->responseType;
        }   
       
        $user = DB::table($userTable)
            ->select('*')
            ->where(['useriD'=>$userID, 'uniqueNo' => $uniqueNo])
            ->get();
        //If combination not found after tampering with Service user not found
        if (!count($user)){
            return view('mobile.pages.userNotFound', ['userType' => $userType, 'username'=>'', 'campaign'=>$campaign] );
        }
      
        //Mr John Doe of 23 London Rd, Redhill
        $extra="";
        if ($responseTypeID==1){
            $extra=' of ' . $user[0]->address;
        }
        $fullusername = $user[0]->title . ' ' . $user[0]->firstName . ' ' . $user[0]->lastName . $extra;
            
        //Real company details
        $selectCompany=DB::select('select companyName, companyID from companyprofiletable where companyID=? ',  [$user[0]->companyID]);
        if ($selectCompany){
            View::share('mobile_companyName', $selectCompany);
        }
        
        //Check if it is ready for the survey,feedback, complaits etc : smsl sent out
        $userResponse = DB::select('select * from  responsetable where userID = ?  and responseTypeID=?   and date_received  is null and sentCount > 0', [$userID, $responseTypeID]);
        if (!$userResponse) {
            return view('mobile.pages.userAlreadyDone' , ['userType' => $userType, 'username'=>$fullusername, 'campaign' => $campaign]);
        }
                    
        //Get the questions details
        $quesType = DB::select('select * from questable');

        //Get the service users question form
        $quesForm=DB::select('select * from ' . $quesFormTable);
        return view($quesFormPage, ['username' => $fullusername,'quesType' =>$quesType,
           'quesForm' => $quesForm ,  'quesCount'=>count($quesForm), 'userID' => $userID, 
           'campaign' => $campaign, 'responseTypeID' => $responseTypeID ]);
    }

    public function save_userFeedback(Request $request){
        
        $userID=$request->userID;
        $responses=$request->responses;
        $quesName=$request->quesName;
        $quesTypeID=$request->quesTypeID;
        $quesOptions=$request->quesOptions;
        $responseTypeID=$request->responseTypeID;       
        $where=
        [
           ['userID', $userID],
           ['responseTypeID', $responseTypeID]
        ];
        
        $q=DB::table('responsetable')
            ->where($where)
            ->whereNull('date_received')
            ->whereNotNull('date_posted')
            ->update([
                   'date_received' => Carbon::now(),
                   'responses' => $responses,
                   'quesName' => $quesName,
                   'quesTypeID' => $quesTypeID,
                   'quesOptions' => $quesOptions,
                   ]);

       return response()->json($request); 
    }   
    
    public function successSaved(Request $request){
        $mobile_companyName=DB::select('select companyName from companyprofiletable where companyID=? ', [$request->companyID]);
       return view('mobile.pages.successSaved',
         ['userType' => 'Customer', 'campaign' => '',
         'mobile_companyName' => $mobile_companyName,
         'username' => "Information Submitted"] );
    }   

}
