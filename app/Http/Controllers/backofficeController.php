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
