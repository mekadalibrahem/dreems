<?php

use App\Models\AdminSetting;
use Illuminate\Support\Facades\Route;
use App\Models\Dream;


Route::group(
    [
        'prefix' => 'test/',
        'as' => 'test.'
    ],
    function () {
        Route::group([
            'prefix' => 'model/',
            'as' => 'model.'
        ], function () {
            Route::group([
                'prefix' => 'dreem/',
                'as' => 'model.'
            ], function () {
                Route::get('/create', function () {
                    $dreem  =  Dream::create([

                        'full_name' => "test name",
                        'description' => 'test description',
                        'amount' => 52,

                    ]);
                    dd($dreem);
                });
                Route::get('/update', function () {
                    $dreem  =  Dream::firstOrCreate([

                        'full_name' => "test name",
                        'description' => 'test description',
                        'amount' => 52,

                    ]);

                    $dreem->full_name = "updated name";
                    $edited = $dreem->save();

                    dd($dreem, $edited);
                });

                Route::get('/all', function () {
                    $dreems  =  Dream::all();



                    dd($dreems);
                });
            });

            // admin_settings 
            Route::group([
                'prefix' => 'admin-settings',
                'as' => 'admin-settings.'
            ], function () {
                Route::get('/create', function () {
                    $s  =  AdminSetting::create([

                        'name' => "test name",
                        'value' => "test value",

                    ]);
                    dd($s);
                });
                Route::get('/update', function () {
                    $s  =  AdminSetting::firstOrCreate([

                        'name' => "test name",
                        'value' => "test value",

                    ]);

                    $s->name = "updated name";
                    $edited = $s->save();

                    dd($s, $edited);
                });

                Route::get('/all', function () {
                    $s  =  AdminSetting::all();



                    dd($s);
                });
            });
        });
    }
);
