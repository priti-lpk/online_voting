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
//Login
Route::get('/', function () {
    return view('login');
});

//Index Page
Route::get('/login', 'LoginController@index');
Route::get('/dashboard', 'LoginController@dashboard');
Route::post('/checklogin', 'LoginController@checklogin');

//Add Election, Edit, Delete
Route::get('/election', 'MainController@election');
Route::post('/add_election', 'MainController@add_election');
Route::get('/edit_election/{id}', 'MainController@get_election')->name('election.edit');
Route::post('/edit_election/{id}', 'MainController@edit_election');
Route::get('/del_election/{id}', 'MainController@del_election')->name('election.delete');

//Add Position, Edit, Delete
Route::get('/position', 'MainController@position');
Route::post('/add_position', 'MainController@add_position');
Route::get('/edit_position/{id}', 'MainController@get_position')->name('position.edit');
Route::post('/edit_position/{id}', 'MainController@edit_position');
Route::get('/del_position/{id}', 'MainController@del_position');

//Add Candidate, Edit, Delete
Route::get('/candidate', 'MainController@candidate');
Route::post('/add_candidate', 'MainController@add_candidate');
Route::get('/edit_candidate/{id}', 'MainController@get_candidate')->name('candidate.edit');
Route::post('/edit_candidate/{id}', 'MainController@edit_candidate');
Route::get('/del_candidate/{id}', 'MainController@del_candidate')->name('candidate.delete');

//ViewResult
Route::get('/view_result', 'MainController@view_result');
Route::get('/view_user', 'MainController@view_user');
Route::post('/changestatus', 'MainController@changestatus');

//Change Pass
Route::get('/change_password', 'LoginController@change_password');
Route::post('/change', 'LoginController@change');
Route::post('/update_pass', 'LoginController@change_pass');

//Logout
Route::get('/logout', function () {
    return view('login');
});
