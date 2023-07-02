<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolRole;
use Illuminate\Support\Str;

class SchoolRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['uuid' => Str::uuid(), 'slug' => 'admin', 'name' => 'Admin'],
            ['uuid' => Str::uuid(), 'slug' => 'staff', 'name' => 'Staff'],
            ['uuid' => Str::uuid(), 'slug' => 'teacher', 'name' => 'Teacher'],
            ['uuid' => Str::uuid(), 'slug' => 'student', 'name' => 'Student'],
        ];

        foreach($data as $d){
            $validate = ['slug' => $d['slug'], 'name' => $d['name']];
            SchoolRole::updateOrInsert($validate,$d);
        }
    }
}
