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
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\UserPaymentController;
use App\Http\Controllers\UserSetAsideController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [AuthController::class,'login']);
Route::post("adminLogin",[AdminController::class,'adminLogin']);
Route::post("register",[AuthController::class,'register']);

//Federal Tender
Route::post('paginateFederalTenders', [FederalTenderController::class,'paginateFederalTenders']);

//State Tender
Route::post('paginateStateTenders', [StateTenderController::class,'paginateStateTenders']);
Route::post('paginateInactiveStateTenders', [StateTenderController::class,'paginateInactiveStateTenders']);
Route::post("showS3BucketFiles", [StateTenderController::class,'showS3BucketFiles']);
Route::post("updateStateTender", [StateTenderController::class,'updateStateTender']);
Route::post("deleteStateTenders", [StateTenderController::class,'deleteStateTenders']);
Route::post("updateTenderState", [StateTenderController::class,'updateTenderState']);
Route::post("deleteStateTender", [StateTenderController::class,'deleteStateTender']);

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

Route::middleware(['api'])->group(function ($router) {

	
	Route::post("changePassword",[UserController::class,'changePassword']);

	Route::post("adminLogout",[AdminController::class,'adminLogout']);

	Route::post("getUserSubscriptions",[UserSubscriptionController::class,'getUserSubscriptions']);
	Route::post("getActiveSubscription",[UserSubscriptionController::class,'getActiveSubscription']);

	Route::post("getUserPayments",[UserPaymentController::class,'getUserPayments']);

	Route::post("paginateUserSubscriptions",[SubscriptionPlanController::class,'paginateUserSubscriptions']);

	//Federal Agency
	Route::post("paginateFederalAgencies",[FederalAgencyController::class,'paginateFederalAgencies']);
	Route::post("addFederalAgency",[FederalAgencyController::class,'addFederalAgency']);
	Route::post("getFederalAgency",[FederalAgencyController::class,'getFederalAgency']);
	Route::post("updateFederalAgency",[FederalAgencyController::class,'updateFederalAgency']);
	Route::post("deleteFederalAgency",[FederalAgencyController::class,'deleteFederalAgency']);

	Route::post("paginateActiveUsers",[AuthController::class,'paginateActiveUsers']);
	
	//User setasides
	Route::post('getUserSetAsideIds', [UserSetAsideController::class,'getUserSetAsideIds']);

	//State Agency
	Route::post("paginateStateAgencies",[StateAgencyController::class,'paginateStateAgencies']);
	Route::post("addStateAgency",[StateAgencyController::class,'addStateAgency']);
	Route::post("getStateAgency",[StateAgencyController::class,'getStateAgency']);
	Route::post("updateStateAgency",[StateAgencyController::class,'updateStateAgency']);
	Route::post("deleteStateAgency",[StateAgencyController::class,'deleteStateAgency']);

	//State Notice
	Route::post("paginateStateNotices",[StateNoticeController::class,'paginateStateNotices']);
	Route::post("addStateNotice",[StateNoticeController::class,'addStateNotice']);
	Route::post("getStateNotice",[StateNoticeController::class,'getStateNotice']);
	Route::post("updateStateNotice",[StateNoticeController::class,'updateStateNotice']);
	Route::post("deleteStateNotice",[StateNoticeController::class,'deleteStateNotice']);

	//User Payment
	Route::post('getUserPayment', [UserPaymentController::class,'getUserPayment']);

	//Cart Item
	Route::post('addCartItem', [CartItemController::class,'addCartItem']);
	Route::post('getCartItemsCount', [CartItemController::class,'getCartItemsCount']);
	Route::post('getCartItems', [CartItemController::class,'getCartItems']);
	Route::post('removeCartItem', [CartItemController::class,'removeCartItem']);
	Route::post('clearCart', [CartItemController::class,'clearCart']);

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

	//Admin Controller
	Route::post("paginateAdmins",[AdminController::class,'paginateAdmins']);
	Route::post("addAdmin",[AdminController::class,'addAdmin']);
	Route::post("getAdmin",[AdminController::class,'getAdmin']);
	Route::post("updateAdmin",[AdminController::class,'updateAdmin']);
	Route::post("deleteAdmin",[AdminController::class,'deleteAdmin']);

	//Alerts
	Route::post("addAlerts", [AlertController::class,'addAlerts']);	
	Route::post("updateAlerts", [AlertController::class,'updateAlerts']);	
	Route::post("createAlerts", [AlertController::class,'createAlerts']);	
	Route::post("getAlert", [AlertController::class,'getAlert']);
	Route::post("paginateAlerts", [AlertController::class,'paginateAlerts']);
	Route::post("deleteAlert", [AlertController::class,'deleteAlert']);	
	Route::post("paginateAllAlerts", [AlertController::class,'paginateAllAlerts']);

	//Federal Notice
	Route::post("paginateFederalNotices",[FederalNoticeController::class,'paginateFederalNotices']);
	Route::post("addFederalNotice",[FederalNoticeController::class,'addFederalNotice']);
	Route::post("getFederalNotice",[FederalNoticeController::class,'getFederalNotice']);
	Route::post("updateFederalNotice",[FederalNoticeController::class,'updateFederalNotice']);
	Route::post("deleteFederalNotice",[FederalNoticeController::class,'deleteFederalNotice']);

	//Api Key
	Route::post("getApiKey",[AdminController::class,'getApiKey']);
	Route::post("updateApiKey",[AdminController::class,'updateApiKey']);	

	//Aws
	Route::post("getAwsFolders",[AdminController::class,'getAwsFolders']);

	//Federal Tender
	Route::post("paginateTenderFederals",[FederalTenderController::class,'paginateTenderFederals']);
	Route::post("addFederalTender",[FederalTenderController::class,'addFederalTender']);
	Route::post("updateTenderFederal",[FederalTenderController::class,'updateTenderFederal']);
	Route::post("updateFederalTender",[FederalTenderController::class,'updateFederalTender']);
	Route::post("deleteFederalTender",[FederalTenderController::class,'deleteFederalTender']);

	//Category
	Route::post("paginateCategories",[CategoryController::class,'paginateCategories']);
	Route::post("addCategory",[CategoryController::class,'addCategory']);
	Route::post("getCategory",[CategoryController::class,'getCategory']);
	Route::post("updateCategory",[CategoryController::class,'updateCategory']);
	Route::post("deleteCategory",[CategoryController::class,'deleteCategory']);
});

//paypal
Route::post("testPaypal",[PaypalController::class,'testPaypal']);
Route::get("paypalSubscriptionSuccess",[PaypalController::class,'paypalSubscriptionSuccess']);
Route::get("paypalPurchaseTenderSuccess",[PaypalController::class,'paypalPurchaseTenderSuccess']);
Route::get("subscriptionCancelpage_func",[PaypalController::class,'subscriptionCancelpage_func']);
Route::post("paypal_ipn_common_func",[PaypalController::class,'paypal_ipn_common_func']);
Route::post("send_mail_invoice_normal_payment",[PaypalController::class,'send_mail_invoice_normal_payment']);