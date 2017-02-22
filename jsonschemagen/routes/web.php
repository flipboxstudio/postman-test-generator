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

/*
Route::get('/', function () {
    return view('json-schema-form');
});*/
Route::get('/', 'genController@home')->middleware('auth');

Route::post('/request_json','genController@jsonschema');

Route::resource('project','ProjectController');

Auth::routes();

Route::get('/home', function(){
    return redirect()->to('/');
});

Route::get('/logout', function(){
    \Auth::logout();
    return redirect()->to('/');
});
