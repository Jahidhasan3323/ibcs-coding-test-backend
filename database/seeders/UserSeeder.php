<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => "Admin",
                'email'    => "admin@gmail.com",
                'password' => Hash::make(12345678),
                'phone'    => "",
                'role'     => 1,
            ]
        );
        //create customer
        User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name'     => "Customer",
                'email'    => "customer@gmail.com",
                'password' => Hash::make(12345678),
                'phone'    => "01234567891s",
                'role'     => 2,
            ]
        );
    }
}
