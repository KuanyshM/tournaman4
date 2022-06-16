<?php

use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/categories', CategoryApiController::class);

Route::post('/search', [SearchController::class,'search']);
Route::post('/searchCity', [SearchController::class,'searchCity']);



