<?php

use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\TrackingController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/categories', CategoryApiController::class);

Route::post('/search', [SearchController::class,'search']);
Route::post('/searchCity', [SearchController::class,'searchCity']);
Route::post('/track', [TrackingController::class,'track']);
Route::post('/checkVideo', [TrackingController::class,'checkVideo']);



