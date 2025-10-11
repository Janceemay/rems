<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder {
    public function run() {
        Role::updateOrCreate(['role_name'=>'Client'], ['description'=>'Can view property listings and their own transactions/payments']);
        Role::updateOrCreate(['role_name'=>'Agent'], ['description'=>'Handles client inquiries and property sales']);
        Role::updateOrCreate(['role_name'=>'Sales Manager'], ['description'=>'Manages agents, approvals, and reports']);
        Role::updateOrCreate(['role_name'=>'Admin'], ['description'=>'System administrator with full access']);
    }
}
