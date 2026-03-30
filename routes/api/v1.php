<?php

use App\Http\Controllers\Api\V1\AccountTypeController;
use App\Http\Controllers\Api\V1\AccountController;

Route::apiResource('account_types', AccountTypeController::class);


Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource('accounts', AccountController::class);
});



