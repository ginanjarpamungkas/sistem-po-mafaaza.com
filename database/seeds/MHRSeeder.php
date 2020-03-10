<?php

use Illuminate\Database\Seeder;

class MHRTableSeeder extends Seeder{
    public function run(){
        \DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\User',
            'model_id' => '1',
        ]);
    }
}
