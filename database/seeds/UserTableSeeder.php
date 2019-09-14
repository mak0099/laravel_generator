<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => "1",
                'email' => "admin@example.com",
                'name' => "Admin",
                'username' => "admin",
                'password' => bcrypt("admin"),
            ],
            [
                'id' => "2",
                'email' => "user@example.com",
                'name' => "User",
                'username' => "user",
                'password' => bcrypt("user"),
            ]
        ]);
        // DB::table('roles')->insert(['name'=>'admin', 'guard_name'=>'web']);
        // DB::table('roles')->insert(['name'=>'user', 'guard_name'=>'web']);
        // App\User::find(1)->assignRole('admin');
        // App\User::find(2)->assignRole('user');
    }
}
