<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'name' => 'user1',
            'email' => 'user1@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'address',
            'city' => 'city',
            'province' => 'province',
            'no_telp' => '123456789',
            'username' => 'user',
            'validate' => '0',
            'api_token' => Str::random(60),
            'remember_token' => Str::random(10),
        ]);
    }
}
