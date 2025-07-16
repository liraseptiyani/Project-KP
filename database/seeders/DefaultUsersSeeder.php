<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Anda mengimpor model User

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('passwordadmin'),
                'role' => 'admin',
            ]
        );

        // User per divisi
        $divisiUsers = [
            ['username' => 'CLD', 'password' => 'cld123'],
            ['username' => 'RPD', 'password' => 'rpd123'],
            ['username' => 'END', 'password' => 'end123'],
            ['username' => 'EID', 'password' => 'eid123'],
            ['username' => 'POD', 'password' => 'pod123'],
            ['username' => 'PTD', 'password' => 'ptd123'],
            ['username' => 'SFD', 'password' => 'sfd123'],
        ];

        foreach ($divisiUsers as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'password' => Hash::make($user['password']),
                    'role' => 'user',
                ]
            );
        }
    }
}
