<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function show_feedback_serviceUser(){
        
        return view('backoffice.pages.show_feedback_serviceUser');
    }
    
    public function build_serviceUserFeedback(){
        
        return view('backoffice.pages.build_serviceUserFeedback');
    }   

    public function build_employeeFeedback(){
        
        return view('backoffice.pages.build_employeeFeedback');
    }



}
