<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FederalTenderController;
use App\Http\Controllers\StateTenderController;
use App\Http\Controllers\PaypalController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('sendFederalTenderMail', [FederalTenderController::class,'sendFederalTenderMail']);
Route::get("downloadStateAttachments/{state_tender_id}",[StateTenderController::class,'downloadStateAttachments']);
Route::get("downloadFederalAttachments/{federal_tender_id}",[FederalTenderController::class,'downloadFederalAttachments']);
Route::get("callPaypalSubscripton",[PaypalController::class,'callPaypalSubscripton']);
Route::get("purchaseTender",[PaypalController::class,'purchaseTender']);
Route::get("updateStateTenderNumber",[StateTenderController::class,'updateStateTenderNumber']);