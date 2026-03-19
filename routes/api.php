<?php

use App\Http\Controllers\Api\RegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('v1')->group(function () {
    require base_path('routes/api/v1.php');
});


Route::prefix("/auth")->group(function () {
    Route::post('/register', RegisterController::class);
});
