<?php

use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserHasEventsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/auth",  [AuthController::class, "login"]);
Route::apiResource("/user", UserController::class);
Route::get("/verifyEmail/{email}",  [UserController::class, "verifyEmail"]);

Route::post("/sendTokenRecoverPassword",  [UserController::class, "sendTokenRecoverPassword"]);
Route::post("/verifyTokenRecover",  [UserController::class, "verifyTokenRecover"]);
Route::put("/updatePassword/{token}",  [UserController::class, "updatePassword"]);

Route::apiResource("/events", EventsController::class);
Route::get("/eventsTitle/{title}",  [EventsController::class, "showTitle"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource("/hasEvents", UserHasEventsController::class);
    Route::post("/events/{id}", [EventsController::class, "update"]);
    Route::post("/hasEvents/{id}", [UserHasEventsController::class, "update"]);
    Route::post("/logout",  [AuthController::class, "logout"]);
});

Route::get("/", function (Request $request) {
    return response()->json([
        'Hi!' => 'I am here! Use me, please.'
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
