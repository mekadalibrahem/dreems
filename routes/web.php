<?php

use App\Models\Dream;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    view('welcome');
})->name('start');


require __DIR__ . "/test.php";