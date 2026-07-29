<?php

namespace Database\Seeders;

use App\Constants\UserConstant;
use App\Models\Classroom;
use App\Models\Lecturer;
use App\Models\Student;
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
            $user = User::updateOrCreate(
                ['email' => $lecturer['email']],
                [
                    'name'              => $lecturer['name'],
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'role'              => UserConstant::Role_Lecturer,
                    'status'            => UserConstant::Status_Approved,
                ]
            );

            Lecturer::updateOrCreate(
                ['user_id' => $user->id],
                ['code' => $this->generateCode($user)]
            );
        }
    }

    protected function seedStudents(): void
    {
        $classrooms = $this->seedClassrooms();

        $students = [
            ['name' => 'Refli Aldi',        'email' => 'ref.a@yeliapp.id',    'classroom' => 'English 1'],
            ['name' => 'Aditya Pratama',    'email' => 'aditya.p@yeliapp.id', 'classroom' => 'English 1'],
            ['name' => 'Nobila Rio',        'email' => 'nobila.r@yeliapp.id', 'classroom' => 'English 2'],
            ['name' => 'Bagas Widyatmaja',  'email' => 'bagas.w@yeliapp.id',  'classroom' => 'English 1'],
            ['name' => 'Citra Dewi',        'email' => 'citra.d@yeliapp.id',  'classroom' => 'English 2'],
            ['name' => 'Fajar Hadi',        'email' => 'fajar.h@yeliapp.id',  'classroom' => 'English 2'],
        ];

        foreach ($students as $student) {
            $user = User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'name'              => $student['name'],
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'role'              => UserConstant::Role_Student,
                    'status'            => UserConstant::Status_Approved,
                ]
            );

            $classroom = $classrooms[$student['classroom']];

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'classroom_id'    => $classroom->id,
                    'classroom_name'  => $classroom->name,
                    'code'            => $this->generateCode($user),
                ]
            );
        }
    }

    protected function seedClassrooms(): array
    {
        $classrooms = [
            ['name' => 'English 1', 'code' => 'ENG-1'],
            ['name' => 'English 2', 'code' => 'ENG-2'],
        ];

        $result = [];

        foreach ($classrooms as $classroom) {
            $result[$classroom['name']] = Classroom::updateOrCreate(
                ['code' => $classroom['code']],
                ['name' => $classroom['name']]
            );
        }

        return $result;
    }

    protected function generateCode(User $user): string
    {
        return date('Ymd') . $user->id . date('H') . rand(99, 999);
    }
}
