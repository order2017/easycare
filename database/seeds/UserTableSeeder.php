<?php

use App\UserOAuthInfo;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->openid = 'o9lU6uIdKZndfu9NTeSkzCQGdQ2c';
        $user->username = 'admin';
        $user->password = Hash::make('123456');
        $user->role = \App\User::ROLE_ADMIN;
        $user->save();
    }
}
