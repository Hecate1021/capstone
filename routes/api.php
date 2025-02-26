<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\User\BookingController;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/bookings/calendar', [BookingController::class, 'calendar']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("push-subscribe", function (Request $request) {
    PushSubscription::create([
        'data' => $request->getContent()
    ]);
});
