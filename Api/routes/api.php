<?php

use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserHasEventsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/", function (Request $request) {
    return response()->json([
        'Hi!' => "I am here! I'm working. Use me, please."
    ]);
});

Route::prefix('v2')->group(function () {
    Route::post("/login",  [AuthController::class, "login"]);
    Route::post("/logout",  [AuthController::class, "logout"]);

    Route::apiResource("/user", UserController::class);
    Route::get("/verifyEmail/{email}",  [UserController::class, "verifyEmail"]);
    Route::post("/reSendToken",  [UserController::class, "reSendToken"]);
    Route::post("/sendTokenRecover",  [UserController::class, "sendTokenRecover"]);
    Route::put("/resetPassword",  [UserController::class, "resetPassword"]);

    Route::apiResource("/events", EventsController::class);
    Route::get("/showTitle/{title}",  [EventsController::class, "showTitle"]);

    Route::apiResource("/userEvents",  UserHasEventsController::class);
    Route::get("/showUserEvents",  [UserHasEventsController::class, "showUserEvents"]);
    Route::get("/showEventsUser/{id}",  [UserHasEventsController::class, "showEventsUser"]);
});
