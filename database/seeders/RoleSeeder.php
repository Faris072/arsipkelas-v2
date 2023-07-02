<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['uuid' => Str::uuid(), 'slug' => 'developer', 'name' => 'Developer'],
            ['uuid' => Str::uuid(), 'slug' => 'admin', 'name' => 'Admin'],
            ['uuid' => Str::uuid(), 'slug' => 'user', 'name' => 'User'],
        ];

        foreach($data as $d){
            $validate = ['slug' => $d['slug'], 'name' => $d['name']];
            Role::updateOrInsert($validate, $d);
        }
    }
}
