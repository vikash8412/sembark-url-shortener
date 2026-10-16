<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL');
        $password = env('SUPERADMIN_PASSWORD');

        if (empty($email) || empty($password)) {
            throw new RuntimeException(
                'Set SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD in .env'
            );
        }

        $existingUser = DB::selectOne(
            'SELECT id FROM users WHERE email = ? LIMIT 1',
            [$email]
        );

        if ($existingUser) {
            $this->command->info(
                'SuperAdmin already exists. No changes made.'
            );

            return;
        }

        $now = now()->toDateTimeString();

        DB::insert(
            'INSERT INTO users
            (name, email, email_verified_at, password, company_id, role, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                'Super Admin',
                $email,
                $now,
                password_hash($password, PASSWORD_DEFAULT),
                null,
                'superadmin',
                $now,
                $now,
            ]
        );

        $this->command->info('SuperAdmin created successfully.');        
    }
}
