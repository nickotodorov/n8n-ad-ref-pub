<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdScriptController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('ad-scripts')
    ->name('api.ad-scripts.')
    ->group(function () {
        Route::post('/', [AdScriptController::class, 'store'])->name('store');
        Route::post('/{task}/result', [AdScriptController::class, 'result'])->name('result');
    });