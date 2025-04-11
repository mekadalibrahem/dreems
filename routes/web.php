<?php

use App\Controllers\AdminController;
use App\Controllers\Auth\LoginController;
use App\Models\Dream;
use Illuminate\Support\Facades\Route;
use App\Controllers\DreamController;
require __DIR__ . "/test.php";


Route::get('/', function () {
    view('welcome');
})->name('start');


Route::group(
    [
        'prefix' => 'dream/',
        'as' => 'dream.'
    ], function () {
        Route::get('create', [DreamController::class, 'create'])->name('create');
        Route::post('/store' , [DreamController::class , 'store'])->name('store');
});


// Route::get('/submit_dream', function () {
   
// });



Route::group(['prefix' => 'admin'], function () {
    Route::get('/login' , [LoginController::class , 'create']);
    Route::post('/login' , [LoginController::class , 'store']);
    Route::get('/dashboard' , [AdminController::class , 'create']);
});
