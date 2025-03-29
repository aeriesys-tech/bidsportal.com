<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FederalTenderController;
use App\Http\Controllers\StateTenderController;
use App\Http\Controllers\PrivateTenderController;
use App\Http\Controllers\InternationalTenderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlertController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('sendFederalTenderMail', [FederalTenderController::class,'sendFederalTenderMail']);
Route::get("downloadStateAttachments/{state_tender_id}",[StateTenderController::class,'downloadStateAttachments']);
Route::get("downloadFederalAttachments/{federal_tender_id}",[FederalTenderController::class,'downloadFederalAttachments']);
Route::get("callPaypalSubscripton",[PaypalController::class,'callPaypalSubscripton']);
Route::get("purchaseTender",[PaypalController::class,'purchaseTender']);
Route::get("updateStateTenderNumber",[StateTenderController::class,'updateStateTenderNumber']);
Route::get("updateFederalTenderNumber",[FederalTenderController::class,'updateFederalTenderNumber']);
Route::get("updatePrivateTenderNumber",[PrivateTenderController::class,'updatePrivateTenderNumber']);
Route::get("updateInternationalTenderNumber",[InternationalTenderController::class,'updateInternationalTenderNumber']);
Route::get("updateFederalTenderNumber",[FederalTenderController::class,'updateFederalTenderNumber']);
Route::get("updateDescriptions",[FederalTenderController::class,'updateDescriptions']);
Route::get("updateAttachments",[FederalTenderController::class,'updateAttachments']);
Route::get("updateUserStatus",[UserController::class,'updateUserStatus']);
Route::get("sendMail",[UserController::class,'sendMail']);
Route::get("sendStateAlertMails",[AlertController::class,'sendStateAlertMails']);
Route::get("updateFederalApi",[FederalTenderController::class,'updateFederalApi']);
Route::get("updateAttachments",[FederalTenderController::class,'updateAttachments']);
Route::get("updateDescription",[FederalTenderController::class,'updateDescription']);
Route::get("updateUserSubscription",[UserController::class,'updateUserSubscription']);
Route::get("deletetodayStateTenders",[StateTenderController::class,'deletetodayStateTenders']);