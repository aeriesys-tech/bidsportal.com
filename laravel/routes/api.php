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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [AuthController::class,'login']);

//Federal Tender
Route::post('paginateFederalTenders', [FederalTenderController::class,'paginateFederalTenders']);

//State Tender
Route::post('paginateStateTenders', [StateTenderController::class,'paginateStateTenders']);

//Pscs
Route::post('getPscs', [PscController::class,'getPscs']);

//Naics
Route::post('getNaics', [NaicsController::class,'getNaics']);

//Federal Notice
Route::post('getFederalNotices', [FederalNoticeController::class,'getFederalNotices']);

//SetAside
Route::post('getSetAsides', [SetAsideController::class,'getSetAsides']);

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

Route::middleware(['api', 'auth:sanctum'])->group(function ($router) {
	
	//Federal Filter
	Route::post("addFederalFilters", [FederalFilterController::class,'addFederalFilters']);	
	Route::post("getFederalFilters", [FederalFilterController::class,'getFederalFilters']);

	//Federal Tender
	Route::post("getFederalTender", [FederalTenderController::class,'getFederalTender']);

	//State Tender
	Route::post("getStateTender", [StateTenderController::class,'getStateTender']);

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
});