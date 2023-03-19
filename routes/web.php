<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Controllers\serviceUserController;
use App\Http\Controllers\backofficeController;
 
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


Route::get('/{uniqueNo}/{id}', [serviceUserController::class, 'index'])->where('id','[0-9]+');
Route::post("serviceUser/save_feedback", [serviceUserController::class, 'save_serviceUserFeedback']);
Route::get("serviceUser/successSaved", [serviceUserController::class, 'successSaved']);


Route::get("dashboard", [backofficeController::class, 'show_dashboard']);
Route::get("serviceUser/addnew", [backofficeController::class, 'addnew_serviceUser']);
Route::get("serviceUser/update", [backofficeController::class, 'update_serviceUser']);
Route::get("serviceUser/show_feedback", [backofficeController::class, 'show_feedback_serviceUser']);
Route::get("buildforms/serviceUserFeedback", [backofficeController::class, 'build_serviceUserFeedback']);
Route::get("buildforms/employeeFeedback", [backofficeController::class, 'build_employeeFeedback']);