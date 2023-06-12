<?php

use App\Http\Controllers\AraArbRuleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvgCalculatorController;
use App\Http\Controllers\AvgCalculatorDetailController;
use App\Http\Controllers\CustomFeeTransactionController;
use App\Http\Controllers\FeeTransactionController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::resource('averaging', AvgCalculatorController::class);
    Route::resource('average-detail', AvgCalculatorDetailController::class);
    Route::resource('custom-fee', CustomFeeTransactionController::class);
});

Route::get('/feeTransaction', [FeeTransactionController::class, 'index']);
Route::get('/ara-arb-rules', [AraArbRuleController::class, 'index']);
