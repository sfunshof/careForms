<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class serviceUserController extends Controller
{
    //
    public function index(Request $request){
        //get the service user details
        $userID = $request->id;
        $uniqueNo=$request->uniqueNo;
 
        $user = DB::select('select * from serviceuserdetailstable where userID = ? and uniqueNo = ?', [$userID,$uniqueNo]);
        //If combination not found from tampering Service user not found
        if (!$user){
            return view('mobile.pages.serviceUserNotFound', ['serviceUser' => $user] );
        }
       
        //Mr John Doe of 23 London Rd, Redhill
        $serviceUser = $user[0]->title . ' ' . $user[0]->firstName . ' ' . $user[0]->lastName . ' of ' . $user[0]->address;


        //Check ifit has already been submitted
        $user = DB::select('select * from  responsetable where userID = ? and date_received  is null', [$userID]);

        if (!$user) {
            return view('mobile.pages.serviceUserAlreadyDone' , ['serviceUser' => $serviceUser] );
        }
       
                
        //Get the questions details
        $quesType = DB::select('select * from questable');
        
        //Get the service users question form
        $quesForm=DB::select('select * from serviceuserformtable');
        return view('mobile.pages.serviceUserHome', ['serviceUser' => $serviceUser,'quesType' =>$quesType,   'quesForm' => $quesForm ,  'quesCount'=>count($quesForm), 'userID' => $userID ]);
    }
    public function save_serviceUserFeedback(Request $request){
        
        $userID=$request->userID;
        $responses=$request->responses;
        $quesName=$request->quesName;
        $quesTypeID=$request->quesTypeID;
        $quesOptions=$request->quesOptions;

        $q=DB::table('responsetable')
            ->where([
                      ['date_received', NULL],
                      ['userID', $userID]
                    ])
            ->update([
                   'date_received' => Carbon::now(),
                   'responses' => $responses,
                   'quesName' => $quesName,
                   'quesTypeID' => $quesTypeID,
                   'quesOptions' => $quesOptions,
                   ]);

       return response()->json($request); 
    }   
    
    public function successSaved(){
        return view('mobile.pages.successSaved');
    }   

}
