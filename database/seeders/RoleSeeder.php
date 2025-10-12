<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder {
    public function run() {
        $roles = [
            ['role_name' => 'Client', 'description' => 'Can view property listings and their own transactions/payments.'],
            ['role_name' => 'Agent', 'description' => 'Handles client inquiries and property sales.'],
            ['role_name' => 'Sales Manager', 'description' => 'Manages agents, approvals, and reports.'],
            ['role_name' => 'Admin', 'description' => 'System administrator with full access.'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['role_name' => $role['role_name']],
                ['description' => $role['description']]
            );
        }

        $this->command->info('✅ Roles seeded successfully!');
    }
}
