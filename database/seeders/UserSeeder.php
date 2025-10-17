<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use App\Models\Agent;
use App\Models\SalesManager;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::firstOrCreate(['role_name' => 'Admin']);
        $managerRole = Role::firstOrCreate(['role_name' => 'Sales Manager']);
        $agentRole = Role::firstOrCreate(['role_name' => 'Agent']);
        $clientRole = Role::firstOrCreate(['role_name' => 'Client']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'role_id' => $adminRole->role_id,
                'full_name' => 'System Administrator',
                'password' => Hash::make('password'),
                'contact_number' => '09171234567',
                'gender' => 'Female',
                'age' => 30,
                'status' => 'active',
            ]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'role_id' => $managerRole->role_id,
                'full_name' => 'John Manager',
                'password' => Hash::make('password'),
                'contact_number' => '09182345678',
                'gender' => 'Male',
                'age' => 35,
                'status' => 'active',
            ]
        );

        SalesManager::updateOrCreate(
            ['user_id' => $manager->user_id],
            [
                'department' => 'Sales Department',
                'quota_id' => null,
                'remarks' => 'Head of Sales'
            ]
        );

        $agent = User::updateOrCreate(
            ['email' => 'agent@example.com'],
            [
                'role_id' => $agentRole->role_id,
                'full_name' => 'Maria Agent',
                'password' => Hash::make('password'),
                'contact_number' => '09193456789',
                'gender' => 'Female',
                'age' => 28,
                'status' => 'active',
            ]
        );

        Agent::updateOrCreate(
            ['user_id' => $agent->user_id],
            [
                'rank' => 'Junior Agent',
                'contact_no' => $agent->contact_number,
                'email' => $agent->email,
                'team_id' => null,
                'manager_id' => $manager->user_id,
                'remarks' => 'New recruit under John Manager'
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'role_id' => $clientRole->role_id,
                'full_name' => 'Carlos Client',
                'password' => Hash::make('password'),
                'contact_number' => '09204567890',
                'gender' => 'Male',
                'age' => 40,
                'status' => 'active',
            ]
        );

        Client::updateOrCreate(
            ['user_id' => $client->user_id],
            [
                'current_job' => 'Engineer',
                'financing_type' => 'Bank Loan',
                'remarks' => 'Prefers long-term payment plans'
            ]
        );

        $this->command->info('Users (Admin, Sales Manager, Agent, Client) seeded successfully!');
    }
}
