<?php

namespace Database\Seeders;

use App\Constants\UserConstant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSuperadmin();
        $this->seedLecturers();
        $this->seedStudents();
    }

    protected function seedSuperadmin(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@yeliapp.id'],
            [
                'name'              => 'Super Administrator',
                'email_verified_at' => now(),
                'password'          => Hash::make('123123123'),
                'role'              => UserConstant::Role_Admin,
                'status'            => UserConstant::Status_Approved,
            ]
        );
    }

    protected function seedLecturers(): void
    {
        $lecturers = [
            ['name' => 'Dr. Yetti Zainil',  'email' => 'yetti.z@yeliapp.id'],
            ['name' => 'Dr. Hovid Ardi',    'email' => 'hovid.a@yeliapp.id'],
        ];

        foreach ($lecturers as $lecturer) {
            User::updateOrCreate(
                ['email' => $lecturer['email']],
                [
                    'name'              => $lecturer['name'],
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'role'              => UserConstant::Role_Lecturer,
                    'status'            => UserConstant::Status_Approved,
                ]
            );
        }
    }

    protected function seedStudents(): void
    {
        $students = [
            ['name' => 'Refli Aldi',        'email' => 'ref.a@yeliapp.id'],
            ['name' => 'Aditya Pratama',    'email' => 'aditya.p@yeliapp.id'],
            ['name' => 'Nobila Rio',        'email' => 'nobila.r@yeliapp.id'],
            ['name' => 'Bagas Widyatmaja',  'email' => 'bagas.w@yeliapp.id'],
            ['name' => 'Citra Dewi',        'email' => 'citra.d@yeliapp.id'],
            ['name' => 'Fajar Hadi',        'email' => 'fajar.h@yeliapp.id'],
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'name'              => $student['name'],
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'role'              => UserConstant::Role_Student,
                    'status'            => UserConstant::Status_Approved,
                ]
            );
        }
    }
}
