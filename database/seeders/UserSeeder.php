<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('role_name','Admin')->first();
        $salesRole = Role::where('role_name','Sales Manager')->first();
        $agentRole = Role::where('role_name','Agent')->first();
        $clientRole = Role::where('role_name','Client')->first();

        $admin = User::create([
            'role_id' => $adminRole->role_id,
            'full_name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $sm = User::create([
            'role_id' => $salesRole->role_id,
            'full_name' => 'Sales Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);

        $agent = User::create([
            'role_id' => $agentRole->role_id,
            'full_name' => 'Agent One',
            'email' => 'agent@example.com',
            'password' => Hash::make('password'),
        ]);

        $clientUser = User::create([
            'role_id' => $clientRole->role_id,
            'full_name' => 'Client One',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
        ]);

        Client::create(['user_id' => $clientUser->user_id, 'current_job'=>'Engineer', 'financing_type'=>'Cash']);
    }
}
