<?php

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

Route::get('/', function () {
    return view('welcome');
    //return "hi";
});

Route::get('/test/{slug}', function () {
    return "hi";
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/verify/{slug1}/{slug2}', [App\Http\Controllers\UserController::class, 'verify']);
Route::get('/confirm', [App\Http\Controllers\UserController::class, 'confirm']);


// Route::get('send/mail', function () {
   
//     $details = [
//         'title' => 'Mail from ItSolutionStuff.com',
//         'body' => 'This is for testing email using smtp'
//     ];
   
//     \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\MyTestMail($details));
   
//     dd("Email is Sent.");


