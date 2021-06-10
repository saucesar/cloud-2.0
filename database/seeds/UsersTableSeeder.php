<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $categoryId = \App\Models\UserCategory::first()->id;

        \App\Models\User::create([
            'name' => 'Admin  admin',
            'email' => 'admin@nuvem.com',
            'password' => bcrypt('123456'),
            'phone' => '8799998888',
            'user_type' => 'admin',
            'category_id' => $categoryId,
        ]);

        \App\Models\User::create([
            'name' => 'Admin Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'phone' => '8799998888',
            'user_type' => 'normal',
            'category_id' => $categoryId,
        ]);
    }
}