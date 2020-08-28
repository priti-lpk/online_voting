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

Route::get('/', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/login', 'LoginController@index');
Route::get('/dashboard', 'LoginController@dashboard');
Route::post('/checklogin', 'LoginController@checklogin');

Route::post('/add_register', 'LoginController@add_register');

Route::get('/voting', 'MainController@voting');
Route::post('/add_vote', 'MainController@add_vote');

Route::get('/change_user_profile', 'LoginController@user_profile');
Route::post('/edit_user/{id}', 'LoginController@edit_user');

Route::get('/change_password', 'LoginController@change_password');
Route::post('/change', 'LoginController@change');
Route::post('/update_pass', 'LoginController@change_pass');

Route::resource('sendemail', 'SendEmail');
Route::post('Email', 'SendEmail@send_mail');