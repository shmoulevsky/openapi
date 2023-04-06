<?php

use App\Http\Controllers\V1\RouteAnnotationController;
use App\Http\Controllers\V1\SchemeController;
use Illuminate\Http\Request;
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

Route::post('/scheme/item', [SchemeController::class , 'item']);
Route::post('/scheme/route-annotation', [RouteAnnotationController::class , 'item']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
