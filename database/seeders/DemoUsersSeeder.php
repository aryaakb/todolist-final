<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin/Dosen Demo Accounts
        $adminUsers = [
            [
                'name' => 'Prof. Dr. Saskia Wijaya',
                'email' => 'saskia.wijaya@unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Admin/Dosen
            ],
            [
                'name' => 'Dr. Vincent Tanujaya',
                'email' => 'vincent.tanujaya@unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Admin/Dosen
            ],
            [
                'name' => 'Dr. Melissa van der Berg',
                'email' => 'melissa.vandenberg@unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Admin/Dosen
            ],
            [
                'name' => 'Prof. Jonathan Liem Suharto',
                'email' => 'jonathan.liem@unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Admin/Dosen
            ],
            [
                'name' => 'Dr. Anastasia Gunawan',
                'email' => 'anastasia.gunawan@unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Admin/Dosen
            ],
        ];

        // Mahasiswa Demo Accounts
        $studentUsers = [
            [
                'name' => 'Alexander Wijaya Chen',
                'email' => 'alexander.wijaya@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Clarissa van der Liem',
                'email' => 'clarissa.vanderliem@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Daniel Andreas Tan',
                'email' => 'daniel.tan@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Gabriella Stephanie Ko',
                'email' => 'gabriella.ko@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Nicholas Hendrick Lim',
                'email' => 'nicholas.lim@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Vanessa Caroline Sutanto',
                'email' => 'vanessa.sutanto@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Kevin Marcellus Wijaya',
                'email' => 'kevin.wijaya@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Michelle Angeline Gozali',
                'email' => 'michelle.gozali@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Brandon Christopher Tanaka',
                'email' => 'brandon.tanaka@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Stephanie Valencia Chen',
                'email' => 'stephanie.chen@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Jonathan William Kusnadi',
                'email' => 'jonathan.kusnadi@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Felicia Grace Handoko',
                'email' => 'felicia.handoko@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Ryan Sebastian Liem',
                'email' => 'ryan.liem@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Celine Theodora Wongso',
                'email' => 'celine.wongso@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
            [
                'name' => 'Marcus Valentine Halim',
                'email' => 'marcus.halim@student.unimus.ac.id',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Mahasiswa
            ],
        ];

        // Insert Admin/Dosen users
        foreach ($adminUsers as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }

        // Insert Student users
        foreach ($studentUsers as $student) {
            User::firstOrCreate(
                ['email' => $student['email']],
                $student
            );
        }

        $this->command->info('Demo users created successfully!');
        $this->command->info('Admin/Dosen accounts: ' . count($adminUsers));
        $this->command->info('Student accounts: ' . count($studentUsers));
        $this->command->info('Default password for all demo accounts: password123');
    }
}