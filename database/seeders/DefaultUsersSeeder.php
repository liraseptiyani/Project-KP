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
        User::create([
            'username' => 'admin',
            'password' => Hash::make('passwordadmin'), // Ganti dengan password yang kuat dan mudah diingat
            'role' => 'admin',
        ]);

        // User
        User::create([
            'username' => 'user',
            'password' => Hash::make('passworduser'), // Ganti dengan password yang kuat
            'role' => 'user',
        ]);
    }
}