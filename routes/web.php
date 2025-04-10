<?php

use App\Models\Dream;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    view('welcome');
})->name('start');

Route::get('/submit_dream', function () {
    view('submit_dream');
});

<<<<<<< HEAD
require __DIR__ . "/test.php";
=======

Route::group(['prefix'=> 'admin'], function () {
    Route::get('/', function () {
        view('admin/index');
    });
    
});
>>>>>>> e10d3e70576b3f0316131fe04e3ef210427434a8
