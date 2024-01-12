<?php

use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserHasEventsController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\UserHasEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/auth",  [AuthController::class, "login"]);

Route::apiResource("/user", UserController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource("/events", EventsController::class);
    Route::apiResource("/hasEvents", UserHasEventsController::class);
    Route::post("/events/{id}", [EventsController::class, "update"]);
    Route::post("/hasEvents/{id}", [UserHasEventsController::class, "update"]);
    Route::post("/logout",  [AuthController::class, "logout"]);
});

// Route::post("/auth", [AuthController::class,"login"])->name("auth");
// Route::delete("/user/{id}", [UserController::class, "destroy"]);
// Route::get("/user/{id}", [UserController::class, "show"]);
// Route::get("/user", [UserController::class, "index"])->name("userIndex");
// Route::patch("/user/{id}", [UserController::class,"update"])->name("");
// Route::post("/user", [UserController::class,"store"])->name("userStore");


Route::get("/", function (Request $request) {
    return response()->json([
        'sucess' => 'true'
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
