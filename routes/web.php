<?php

use App\Models\Dream;
use Illuminate\Support\Facades\Route;

require __DIR__ . "/test.php";


Route::get('/', function () {
    view('welcome');
})->name('start');

Route::get('/submit_dream', function () {
    view('submit_dream');
});




Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        view('admin/index');
    });
});
