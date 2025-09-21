<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Allan',
            'email' => 'allan.pessin@outlook.com',
            'password' => Hash::make('Mudar@123'),
        ]);
    }
}
