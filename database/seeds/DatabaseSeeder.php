<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    public function run(){
        $this->call(UsersSeeder::class);

        $roles = ['Administrator','Supervisor','Gudang'];
        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name'      =>  $role,
                'guard_name'=>  'web'
            ]);    
        }
        
        \DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\User',
            'model_id' => '1',
        ]);
    }
}
