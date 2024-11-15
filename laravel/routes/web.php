<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FederalTenderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('sendFederalTenderMail', [FederalTenderController::class,'sendFederalTenderMail']);
