<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// // php php
Route::get('/test-api', function () {
    return view('index');
});
// Route::get('/', function () {
//     // return view('index');
//     // Artisan::call('optimize');
//     // Artisan::call('optimize:clear');
//     // Artisan::call('config:cache');
//     // // Artisan::call('migrate:fresh');
//     // Artisan::call('storage:link');

//     // return 'success';
//     return to_route('app');
//     // return to_route('login');
//     // return redirect(route('db-migrate'));
// });
