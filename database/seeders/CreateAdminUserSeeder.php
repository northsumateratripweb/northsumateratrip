<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'Bismillah00';

        $users = [
            [
                'username' => 'ridho',
                'name' => 'Ridho',
                'email' => 'ridho@northsumateratrip.test',
            ],
            [
                'username' => 'posma',
                'name' => 'Posma',
                'email' => 'posma@northsumateratrip.test',
            ],
        ];

        foreach ($users as $data) {
            $user = User::where('email', $data['email'])
                ->orWhere('username', $data['username'])
                ->first();

            if (! $user) {
                User::create([
                    'username' => $data['username'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                ]);
            } else {
                $user->update([
                    'username' => $data['username'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                ]);
            }
        }
    }
}
