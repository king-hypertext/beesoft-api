<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Organization;
use App\Models\OrgDepartments;
use App\Models\OrgParent;
use App\Models\OrgUser;
use App\Models\User;
use App\Models\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $roles = ['super-admin', 'sub-admin', 'admin', 'user', 'security', 'front-desk'];
        // foreach ($roles as $role) {
        //     UserRole::create([
        //         'role' => $role,
        //     ]);
        // }
        // $acc_status = ['active', 'inactive', 'owing school fees', 'suspended'];
        // foreach ($acc_status as $status) {
        //     \App\Models\UserAccountStatus::create([
        //         'status' => $status,
        //     ]);
        // }
        // User::create([
        //     'email' => 'super.admin@example.com',
        //     'phone_number' => '1234567890',
        //     'role_id' => 1,
        //     'account_status_id' => 1
        // ]);
        // Organization::factory(10)->create();
        // OrgDepartments::factory(5)->create();
        // OrgUser::factory(10)->create();
        // Card::factory(20)->create();
        OrgParent::factory(2)->create();
    }
}
