<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::post('twallet', 'API\UserController@updatetwallet');
Route::get('showtwallet', 'API\UserController@showtwallet');
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::post('/createMeetup', 'API\MeetupController@store');
Route::post('/createProject', 'API\ProjectController@store');
Route::get('/meetups', 'API\MeetupController@show');
Route::get('/projects', 'API\ProjectController@show');
Route::get('/myprojects', 'API\UserController@myProjects');
Route::post('twallet', 'API\UserController@updatetwallet');
Route::get('twallet', 'API\UserController@twallet');
Route::get('meetup', 'API\UserController@meetup');
Route::get('fetchTotal', 'API\UserController@fetchTotal');
Route::get('userProjects', 'API\ProjectController@userProjects');
Route::get('post', 'API\UserController@post');
Route::delete('meetup/{id}', 'API\MeetupController@destroy');
Route::put('meetup/{id}', 'API\MeetupController@update');
Route::put('project/{id}', 'API\ProjectController@update');
Route::post('attendMeetup/{id}', 'API\MeetupController@register');
Route::post('joinProject/{id}', 'API\ProjectController@register');
Route::post('leaveProject/{id}', 'API\ProjectController@leave');
Route::get('checkMeetup/{id}', 'API\MeetupController@check');
Route::delete('project/{id}', 'API\ProjectController@destroy');
Route::get('findUser', 'API\UserController@search');
Route::get('userdownload', 'API\UserController@usersdownload');
Route::get('meetupAttendees/{id}', 'API\MeetupController@attendees');
Route::delete('post/{id}', 'PostsController@destroy');
Route::post('post', 'PostsController@store');
Route::put('postUpdate/{id}', 'PostsController@update');
Route::get('generateStatement/{id}', 'API\UserController@generateInvoice');