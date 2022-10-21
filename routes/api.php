<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DelegatorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ValidatorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/validators',[ValidatorController::class, 'get']);
Route::get('/validators/{id}',[ValidatorController::class, 'id']);

Route::post('/delegators',[DelegatorController::class, 'get']);
Route::post('/events',[EventController::class, 'get']);