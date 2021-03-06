<?php

use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

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
    return view('welcome');
});

Route::get('signup' , function() {
    return view('signup');
});


Route::post('thanks' , function(){
    return view('thanks');
});

Route::get('pages' , function (){
    return view('pages');
});



Route::get('/home', 'HomeController@index')->name('home');


Route::get('/fcm' , 'HomeController@testFCM');
Route::get('/send-notification' , 'HomeController@sendNotification');
