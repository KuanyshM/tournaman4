<?php

use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/categories', CategoryApiController::class);

Route::post('search', 'SearchController@search');
Route::post('/search', [\App\Http\Controllers\API\SearchController::class,'search']);


