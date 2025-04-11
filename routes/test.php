<?php

use App\Core\Hashing\Hash as HashingHash;
use App\Core\Helper\Session;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Route;
use App\Models\Dream;


Route::group(
        [
            'prefix' => 'test/',
            'as' => 'test.'
        ],
        function () {
            Route::group(
                
                [
                    'prefix' => 'model/',
                    'as' => 'model.'
                ], function () {
                        Route::group(
                            [
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
                        Route::group(
                            [
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

            Route::group(
                [
                    'prefix' => 'session',
                    'as' => 'session.'
                ],
                function () {
                    Route::get('/', function () {
                        Session::put("puting", "yes");
                        Session::flash('flashing',  "flash data");
                        Session::error('erroring', 'error data');
                        Session::old('olding', 'old data');
                        $s = Session::get(null);
                        $flashing = flashing();
                        $old = old('olding');
                        Session::destroy();
                        dd(
                            $s,
                            $flashing,
                            errors(),
                            has_error('erroring'),
                            has_error('erroringsssas'),
                            error('erroring'),
                            $old

                        );
                    });
                }
            );
            

            // Hash 
            Route::group(
                [
                    'prefix' => 'hash/',
                ] , function(){
                    
                    Route::get('hashing' , function(){
                      
                        $h2 = HashingHash::hash('passwrd');
                        dd($h2);
                    });
            });
});
