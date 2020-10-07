<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Login page
Route::get('/', function () {
    return view('login');
});
//Auth::routes(['verify' => true]);
//Register Page
Route::get('/register', function () {
    return view('register');
});
//Login Controller
Route::get('/login', 'LoginController@index');

//Dashboard
Route::get('/dashboard', 'LoginController@dashboard');
Route::post('/checklogin', 'LoginController@checklogin');

//Register
Route::post('/add_register', 'LoginController@add_register');

//Voting page and insert
Route::get('/voting', 'MainController@voting');
Route::post('/add_vote', 'MainController@add_vote');

//User profile edit
Route::get('/change_user_profile', 'LoginController@user_profile');
Route::post('/edit_user/{id}', 'LoginController@edit_user');

//chage pass
Route::get('/change_password', 'LoginController@change_password');
Route::post('/change', 'LoginController@change');
Route::post('/update_pass', 'LoginController@change_pass');

//Send Mail
Route::resource('sendemail', 'SendEmail');
Route::post('Email', 'SendEmail@send_mail');

//Get pos data
Route::post('getdata', 'MainController@get_position');

//Check email
Route::post('/checkemail', function (Request $request) {
    $email = $request->input('email');
    $getdata = DB::table('user_table')->where('email_id', $email)->get();
    foreach ($getdata as $data) {
        $id = $data->email_id;
        if ($id = '') {
            return "0";
        } else {
            return "1";
        }
    }
});

//Logout
Route::get('/logout', function () {
    return view('login');
});
