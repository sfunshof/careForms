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
        //http://west/4ew2hy54xs7

        View::share('mobile_companyName', '');
        $campaign='Unknown Campaign';
        $unique_value=$request->unique_value;
        
        //ResponseTypeID is valid; what is the csmpaign name
        $resp = DB::table("responsetable")
            ->select('*')
            ->where(['unique_value'=>$unique_value])
            ->whereNull('date_received')
            ->get();
        //If combination not found after tampering with Service user not found
        if (!count($resp)){
            return view('mobile.pages.userNotFound', ['userType' =>'User', 'username'=>'', 'campaign'=>$campaign] );
        }
    

        //Hey we found a user, check if it has nt yet been submitted
        if (!is_null($resp[0]->date_received)){
            return view('mobile.pages.userAlreadyDone' , ['userType' => 'User', 'username'=>'', 'campaign' => 'Submitted']);
        }
        //Expired -- implement later
        // if ($resp[0]->date_posted, now(()) > 30)
        
        //*** Everything OK fire On */
        //Now get the details
        $userTable='';
        $responseTypeID=$resp[0]->responseTypeID;
        $campaign='';
        if ($responseTypeID==1){
            $userTable="serviceuserdetailstable";
            $userType="ServiceUser";
            $quesFormTable="serviceuserformtable";
            $quesFormPage="mobile.pages.serviceUserHome";
        }  
        //ResponseTypeID is valid; what is the csmpaign name
        $respX = DB::table("responsetypetable")
         ->select('*')
         ->where(['responseTypeiD'=>$responseTypeID])
         ->get();
        if (count($respX)) {
             $campaign=$respX[0]->responseType;
        }   
       
        $user = DB::table($userTable)
        ->select('*')
        ->where(['useriD'=>$resp[0]->userID])
        ->get();
        //If db is hacked or corrupted
        if (!count($user)){
            return view('mobile.pages.userNotFound', ['userType' => 'User ', 'username'=>'', 'campaign'=>''] );
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
                
        //Get the questions details
        $quesType = DB::select('select * from questable');

        //Get the service users question form
        $quesForm=DB::select('select * from ' . $quesFormTable);
        return view($quesFormPage, ['username' => $fullusername,'quesType' =>$quesType,
           'quesForm' => $quesForm ,  'quesCount'=>count($quesForm), 'userID' => $resp[0]->userID, 
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
