<?php

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// // php php
// Route::get('/test-api', function () {
//     return view('index');
// });
Route::get('/', function () {
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    $roles = [
        'super-admin',
        'sub-admin',
        'admin',
        'user',
        'parent',
    ];
    foreach ($roles as $role) {
        UserRole::create([
            'role' => $role,
        ]);
    }
    $statues = ['active', 'inactive', 'deleted', 'owing fees'];
    foreach ($statues as $status) {
        \App\Models\UserAccountStatus::create([
            'status' => $status,
        ]);
    }
    User::create([
        'fullname' => 'Super admin',
        'email' => 'super.admin@example.com',
        'phone_number' => '0901234567',
        'account_status_id' => 1,
        'role_id' => 1,
    ]);

    return 'success';
    // return redirect(route('db-migrate'));
});
// Route::get('/db-migrate', function () {
//     $roles = [
//         'super-admin',
//         'sub-admin',
//         'admin',
//         'user',
//         'parent',
//     ];
//     foreach ($roles as $role) {
//         UserRole::create([
//             'role' => $role,
//         ]);
//     }
//     $statues = ['active', 'inactive', 'deleted', 'owing fees'];
//     foreach ($statues as $status) {
//         \App\Models\UserAccountStatus::create([
//             'account_status' => $status,
//         ]);
//     }
//     User::create([
//         'fullname' => 'Super admin',
//         'email' => 'super.admin@example.com',
//         'phone_number' => '',
//         'account_status_id' => 1,
//         'role_id' => 1,
//     ]);

//     return 'success';
// })->name('db-migrate');
