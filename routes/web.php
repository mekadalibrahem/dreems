<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    view('welcome');
});

Route::get('/submit_dream', function () {
    view('submit_dream');
});


Route::group(['prefix'=> 'admin'], function () {
    Route::get('/', function () {
        view('admin/index');
    });
    
});
