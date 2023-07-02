<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['uuid' => Str::uuid(), 'role_id' => 1, 'name' => 'Developer', 'username' => 'developer', 'email' => 'farisbos.mfs@gmail.com', 'phone' => '085706389042', 'password' => 'Faris072'],
            ['uuid' => Str::uuid(), 'role_id' => 2, 'name' => 'Administrator', 'username' => 'admin', 'email' => 'mufashadesu@gmail.com', 'phone' => '085706389043', 'password' => 'Faris072'],
            ['uuid' => Str::uuid(), 'role_id' => 3, 'name' => 'Administrator 2', 'username' => 'admin2', 'email' => 'mufashadesu2@gmail.com', 'phone' => '085706389044', 'password' => 'Faris072'],
        ];

        foreach($data as $d){
            $validate = ['username' => $d['username'], 'email' => $d['email'], 'phone' => $d['phone']];
            User::updateOrInsert($validate,$d);
        }
    }
}
