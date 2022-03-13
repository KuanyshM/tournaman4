<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventCommentController;


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);

Route::get('/products', [
    ProductController::class,
    'index',
]);

Route::get('/articles/detail/{id}', [
    ArticleController::class,
    'detail',
]);
Route::get('/events/detail/{id}', [
    EventController::class,
    'detail',
]);
Route::get('/', [
    ArticleController::class, 'index'
]);
Route::get('/', [
    EventController::class, 'index'
]);

Route::get('/articles/add', [ArticleController::class, 'add']);
Route::get('/events/add', [EventController::class, 'add']);

Route::post('/articles/add', [
    ArticleController::class,
    'create',
]);
Route::post('/events/add', [
    EventController::class,
    'create',
]);

Route::get('/articles/delete/{id}', [
    ArticleController::class,
    'delete',
]);
Route::get('/events/delete/{id}', [
    EventController::class,
    'delete',
]);

Route::post('/comments/add', [
    CommentController::class,
    'create',
]);
Route::post('/event-comments/add', [
    EventCommentController::class,
    'create',
]);

Route::get('/comments/delete/{id}', [
    CommentController::class,
    'delete',
]);
Route::get('/event-comments/delete/{id}', [
    EventCommentController::class,
    'delete',
]);

Auth::routes();

