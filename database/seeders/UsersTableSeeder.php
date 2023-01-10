<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_data = array(
            'name'    => 'Admin',
            'user_name'    => 'admin',
            'email'    => 'admin@gmail.com',
            'password'    => '$2y$10$Lr9SBjlEVczNxYHidlc86O.Z7J1cS1TOYBLL7Qlmg4iJlrxbc5ArG', // Password : 12345678
            'role'    => 1
            );
            
        DB::table('users')->insert($admin_data);
    }
}
