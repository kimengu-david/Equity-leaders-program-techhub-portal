<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use App\Mail\NewUserWelcomeMail;

//The following are the new routes in use.

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'AuthController@dashboard');
});

//Route::get('login', 'AuthController@index');
Route::post('post-login', 'AuthController@postLogin'); //->name('login');
//Route::get('dashboard', 'AuthController@dashboard');
Route::get('logout', 'AuthController@logout')->name('logout');
//End of the new routes.
//Auth::routes();
//The following routes are used in registration of the user.

Route::get('/register', 'AuthController@registrationForm');
Route::post('/register', 'AuthController@registerUser');

//for testing.

Route::get('/email', function () {
    return new NewUserWelcomeMail();

});

Route::post('/follow/{user}', 'FollowsController@store');
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/home', 'ProfilesController@index')->name('home');
Route::get('/', 'PostsController@index');
//The below route is for testing The argument user was removed from profiles.index method.
//The below route responsible for posts shown on homepage.
Route::get('/', 'ProfilesController@index')->name('profile.show');
//Route::post('/p/create', 'PostsController@create');

Route::get('/p/{post}', 'PostsController@show');

Route::post('post', 'PostsController@store');

Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');

Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

//The following routes are to be implemented.
Route::post('post-login', 'AuthController@postLogin');
Route::get('registration', 'AuthController@registration');
Route::post('post-registration', 'AuthController@postRegistration');
Route::post('/twallet', 'UserController@updatetwallet');

Route::delete('post/{id}', 'PostsController@destroy');
Route::get('{path}', "ProfilesController@index")->where('path', '([A-z\d\-\/_.]+)?');