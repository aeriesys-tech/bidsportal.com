<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FederalTenderController;
use App\Http\Controllers\StateTenderController;
use App\Http\Controllers\PscController;
use App\Http\Controllers\NaicsController;
use App\Http\Controllers\FederalNoticeController;
use App\Http\Controllers\SetAsideController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\FederalAgencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FederalFilterController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\StateNoticeController;
use App\Http\Controllers\StateAgencyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StateFilterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\PaypalController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [AuthController::class,'login']);
Route::post("adminLogin",[AdminController::class,'adminLogin']);

//Federal Tender
Route::post('paginateFederalTenders', [FederalTenderController::class,'paginateFederalTenders']);

//State Tender
Route::post('paginateStateTenders', [StateTenderController::class,'paginateStateTenders']);
Route::post('paginateInactiveStateTenders', [StateTenderController::class,'paginateInactiveStateTenders']);
Route::post("showS3BucketFiles", [StateTenderController::class,'showS3BucketFiles']);
Route::post("updateStateTender", [StateTenderController::class,'updateStateTender']);
Route::post("deleteStateTenders", [StateTenderController::class,'deleteStateTenders']);

//Pscs
Route::post('getPscs', [PscController::class,'getPscs']);

//Naics
Route::post('getNaics', [NaicsController::class,'getNaics']);

//Federal Notice
Route::post('getFederalNotices', [FederalNoticeController::class,'getFederalNotices']);

//SetAside
Route::post('getSetAsides', [SetAsideController::class,'getSetAsides']);

//Country
Route::post("getCountries",[CountryController::class,'getCountries']);

//State
Route::post("getStates",[StateController::class,'getStates']);

//Federal Agency
Route::post("getFederalAgencies",[FederalAgencyController::class,'getFederalAgencies']);

//State Notice
Route::post('getStateNotices', [StateNoticeController::class,'getStateNotices']);

//State Agency
Route::post("getStateAgencies",[StateAgencyController::class,'getStateAgencies']);

//Categories
Route::post("getCategories",[CategoryController::class,'getCategories']);

//Subscription Plan
Route::post('getSubscriptionPlans', [SubscriptionPlanController::class,'getSubscriptionPlans']);

Route::middleware(['api', 'auth:sanctum'])->group(function ($router) {

	//Federal Mail
	Route::post('sendFederalTenderMail', [FederalTenderController::class,'sendFederalTenderMail']);

	//Federal Filter
	Route::post("addFederalFilters", [FederalFilterController::class,'addFederalFilters']);	
	Route::post("getFederalFilters", [FederalFilterController::class,'getFederalFilters']);

	//Federal Tender
	Route::post("getFederalTender", [FederalTenderController::class,'getFederalTender']);

	//State Tender
	Route::post("getStateTender", [StateTenderController::class,'getStateTender']);
	Route::post("addStateTender", [StateTenderController::class,'addStateTender']);
	Route::post("updateStateBids", [StateTenderController::class,'updateStateBids']);
	Route::post('sendStateTenderMail', [StateTenderController::class,'sendStateTenderMail']);

	//State Filter
	Route::post("addStateFilters", [StateFilterController::class,'addStateFilters']);	
	Route::post("getStateFilters", [StateFilterController::class,'getStateFilters']);

	//Alerts
	Route::post("addAlerts", [AlertController::class,'addAlerts']);	
	Route::post("updateAlerts", [AlertController::class,'updateAlerts']);	
	Route::post("createAlerts", [AlertController::class,'createAlerts']);	
	Route::post("getAlert", [AlertController::class,'getAlert']);
	Route::post("paginateAlerts", [AlertController::class,'paginateAlerts']);
	Route::post("deleteAlert", [AlertController::class,'deleteAlert']);	

	//Api Key
	Route::post("getApiKey",[AdminController::class,'getApiKey']);
	Route::post("updateApiKey",[AdminController::class,'updateApiKey']);	

	//Aws
	Route::post("getAwsFolders",[AdminController::class,'getAwsFolders']);
});

//paypal
Route::post("testPaypal",[PaypalController::class,'testPaypal']);
Route::get("paypal_success_common_func",[PaypalController::class,'paypal_success_common_func']);
Route::get("subscriptionCancelpage_func",[PaypalController::class,'subscriptionCancelpage_func']);
Route::post("paypal_ipn_common_func",[PaypalController::class,'paypal_ipn_common_func']);
Route::post("send_mail_invoice_normal_payment",[PaypalController::class,'send_mail_invoice_normal_payment']);