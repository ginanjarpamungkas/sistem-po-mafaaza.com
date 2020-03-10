<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder{
    public function run(){
        \DB::table('users')->insert([
            'name' => 'Administrator',
            'role_id' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'created_at' => '1996-09-28 21:17:50'
        ]);
    }
}
