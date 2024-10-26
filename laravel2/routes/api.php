<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FederalTenderController;
use App\Http\Controllers\PscController;
use App\Http\Controllers\NaicsController;
use App\Http\Controllers\FederalNoticeController;
use App\Http\Controllers\SetAsideController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\FederalAgencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FederalFilterController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [AuthController::class,'login']);

Route::post('paginateFederalTenders', [FederalTenderController::class,'paginateFederalTenders']);
Route::post('getPscs', [PscController::class,'getPscs']);
Route::post('getNaics', [NaicsController::class,'getNaics']);
Route::post('getFederalNotices', [FederalNoticeController::class,'getFederalNotices']);
Route::post('getSetAsides', [SetAsideController::class,'getSetAsides']);
Route::post("getStates",[StateController::class,'getStates']);
Route::post("getFederalAgencies",[FederalAgencyController::class,'getFederalAgencies']);

Route::middleware(['api', 'auth:sanctum'])->group(function ($router) {
	
	//Federal Filter
	Route::post("addFederalFilters", [FederalFilterController::class,'addFederalFilters']);	
	Route::post("getFederalFilters", [FederalFilterController::class,'getFederalFilters']);	
});