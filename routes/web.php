<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return 'Hello from Laravel Routing!';
});

Route::get('/users', function () {
    $users = User::all();
    return $users->toJson();
});

Route::get('/user/{id}', function ($id) {
    $user = User::find($id);
    return $user ? $user->toJson() : 'User not found';
});
