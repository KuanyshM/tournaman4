<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\EventCommentController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\UserController;



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::resource('organizations', \App\Http\Controllers\OrganizationController::class);
    Route::resource('teams', \App\Http\Controllers\TeamController::class);
    Route::resource('settings', \App\Http\Controllers\SettingsController::class);
});

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
Route::get('/events/presentation/', [
    EventController::class,
    'presentation',
]);
Route::get('/', [
    ArticleController::class, 'index'
]);
Route::get('/', [
    EventController::class, 'index'
]);

Route::get('/articles/add', [ArticleController::class, 'add']);
Route::get('/events/add', [EventController::class, 'add']);
Route::get('/events/addVideo', [EventController::class, 'addVideo']);

Route::post('/articles/add', [
    ArticleController::class,
    'create',
]);
Route::post('/events/add', [
    EventController::class,
    'create',
]);
Route::post('/events/createVideo', [
    EventController::class,
    'createVideo',
]);
Route::get('/events/edit/{id}', [
    EventController::class,
    'edit',
]);
Route::post('/events/update/{id}', [
    EventController::class,
    'update',
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
Route::get('/profile',
    [UserController::class,
        'profile']);

Route::get('/events/my', [
    EventController::class,
    'myevents',
]);
Route::get('/events/myVideos', [
    EventController::class,
    'myVideos',
]);
Route::get('/events/statistics/{eventId}', [
    StatisticsController::class,
    'statisticsEvent',
]);
Route::get('/events/statistics/{eventId}/sessionsList', [
    StatisticsController::class,
    'sessionsList',
]);
Route::get('/events/statistics/{eventId}/session/{sessionId}', [
    StatisticsController::class,
    'statistics',
]);
Route::get('/events/participants/{id}', [
    EventController::class,
    'participants',
]);
Route::get('/events/organization/{id}', [
    EventController::class,
    'organizationEvents',
]);
Route::get('/events/category/{id}', [
    EventController::class,
    'category',
]);
Route::get('/events/search', [
    EventController::class,
    'search',
]);
Route::post('/events/event-like', [
    EventController::class,
    'like',
]);
Route::post('/events/event-participate', [
    EventController::class,
    'participate',
]);
Route::post('/events/event-participate-team', [
    EventController::class,
    'participateTeam',
]);
Route::post('/events/event-participate/status', [
    EventController::class,
    'ParticipationStatus',
]);
Route::post('/organizations/organization-follow', [
    \App\Http\Controllers\OrganizationController::class,
    'follow',
]);
Route::get('/organizations/{id}/{withEvents}', [
    \App\Http\Controllers\OrganizationController::class,
    'show',
]);
Route::get('/rankings', [
    UserController::class,
    'rankings',
]);
Route::post('/teams/create', [
    \App\Http\Controllers\UserTeamController::class,
    'store',
]);
Route::get('/teams/{id}/members', [
    \App\Http\Controllers\TeamController::class,
    'members',
]);
Route::get('/teams/{id}/requests', [
    \App\Http\Controllers\TeamController::class,
    'requests',
]);
Route::post('/teams/members/remove', [
    \App\Http\Controllers\TeamController::class,
    'removeTeamMember',
]);
Route::post('/teams/requests/remove', [
    \App\Http\Controllers\TeamController::class,
    'removeTeamRequest',
]);
Route::post('/teams/requests/accept', [
    \App\Http\Controllers\TeamController::class,
    'acceptTeamRequest',
]);
Auth::routes();

