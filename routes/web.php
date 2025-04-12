<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\Auth\LoginController;
use App\Models\Dream;
use Illuminate\Support\Facades\Route;
use App\Controllers\DreamController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

require __DIR__ . "/test.php";


Route::get('/', function () {
    view('welcome');
})->name('start');


Route::group(
    [
        'prefix' => 'dream/',
        'as' => 'dream.'
    ],
    function () {
        Route::get('create', [DreamController::class, 'create'])->name('create');
        Route::post('/store', [DreamController::class, 'store'])->name('store');
    }
);


// Route::get('/submit_dream', function () {

// });



Route::group(['prefix' => 'admin/'], function () {
    Route::get('login', [LoginController::class, 'create']);
    Route::post('login', [LoginController::class, 'store']);
    Route::get('dashboard', [DashboardController::class, 'create']);
    Route::post('fulfill_dream', [DashboardController::class, 'fulfill_dream']);
    Route::get('random', [DashboardController::class, 'random_dream']);
    Route::post('dream/delete', [DreamController::class, 'delete_dream']);
    Route::post('dream/accept' , [DreamController::class , 'accept']);
});
