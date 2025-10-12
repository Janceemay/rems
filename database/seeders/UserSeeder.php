<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Role, Client, Agent, SalesManager};

class UserSeeder extends Seeder {
    public function run() {
        $adminRole = Role::where('role_name', 'Admin')->first();
        $managerRole = Role::where('role_name', 'Sales Manager')->first();
        $agentRole = Role::where('role_name', 'Agent')->first();
        $clientRole = Role::where('role_name', 'Client')->first();

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'role_id' => $adminRole->role_id,
                'full_name' => 'System Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        $managerUser = User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'role_id' => $managerRole->role_id,
                'full_name' => 'Sales Manager',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        SalesManager::updateOrCreate(
            ['user_id' => $managerUser->user_id],
            ['department' => 'Sales Department', 'quota_id' => null]
        );

        $agentUser = User::updateOrCreate(
            ['email' => 'agent@example.com'],
            [
                'role_id' => $agentRole->role_id,
                'full_name' => 'Agent One',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        Agent::updateOrCreate(
            ['user_id' => $agentUser->user_id],
            ['rank' => 'Junior Agent', 'contact_no' => '09123456789', 'email' => $agentUser->email]
        );

        $clientUser = User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'role_id' => $clientRole->role_id,
                'full_name' => 'Client One',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        Client::updateOrCreate(
            ['user_id' => $clientUser->user_id],
            ['current_job' => 'Engineer', 'financing_type' => 'Cash']
        );

        $this->command->info('✅ Users, Agents, Managers, and Clients seeded successfully!');
    }
}
