<?php

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
    Route::get('/', function () {
        view('admin/index');
    });
});
