<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Controllers\mobileController;
use App\Http\Controllers\backofficeController;
use App\Http\Controllers\utilityController;
 
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return "Hello";
});


Route::get('{unique_value}', [mobileController::class, 'index']);
Route::post("user/save_feedback", [mobileController::class, 'save_userFeedback']);
Route::get("user/successSaved/{companyID}", [mobileController::class, 'successSaved']);

Route::get("backoffice/dashboard", [backofficeController::class, 'show_dashboard']);
Route::get("backoffice/companyprofile", [backofficeController::class, 'update_companyProfile']);

Route::get("serviceUser/addnew", [backofficeController::class, 'addnew_serviceUser']);
Route::get("serviceUser/update", [backofficeController::class, 'update_serviceUser']);

Route::get("serviceUser/show_surveyfeedback", [backofficeController::class, 'show_surveyFeedback_serviceUser']);
Route::get("serviceUser/show_surveyfeedback/{month}/{year}/{pageNo}", [backofficeController::class, 'show_surveyFeedback_serviceUser']);

Route::get("user/view_feedback/{userID}/{unique_value}/{responseTypeID}", [backofficeController::class, 'view_feedback'])->where(['userID'=>'[0-9]+',  'responseTypeID'=>'[0-9]+']);

Route::get("serviceUser/show_complaints", [backofficeController::class, 'show_complaints_serviceUser']);
Route::get("serviceUser/show_compliments", [backofficeController::class, 'show_compliments_serviceUser']);

Route::get("buildforms/serviceUserFeedback", [backofficeController::class, 'build_serviceUserFeedback']);
Route::get("buildforms/employeeFeedback", [backofficeController::class, 'build_employeeFeedback']);


Route::post("utility/user_sendsms", [utilityController::class, 'user_sendSMS']);
Route::post("utility/serviceuser_viewresponse", [utilityController::class, 'serviceuser_viewResponse']);