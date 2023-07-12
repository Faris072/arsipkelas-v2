<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SchoolRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try{
            $data = [
                ['id' => 1, 'uuid' => Str::uuid(), 'slug' => 'admin', 'name' => 'Admin'],
                ['id' => 2, 'uuid' => Str::uuid(), 'slug' => 'staff', 'name' => 'Staff'],
                ['id' => 3, 'uuid' => Str::uuid(), 'slug' => 'teacher', 'name' => 'Teacher'],
                ['id' => 4, 'uuid' => Str::uuid(), 'slug' => 'student', 'name' => 'Student'],
            ];

            foreach($data as $d){
                $validate = ['slug' => $d['slug'], 'name' => $d['name']];
                SchoolRole::updateOrInsert($validate,$d);
            }

            //alter sequence
            $lastId = SchoolRole::latest('id')->first()->id;
            $newLastId = $lastId + 1;
            DB::update(DB::raw("ALTER SEQUENCE school_roles_id_seq RESTART {$newLastId}"));

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            echo $e;
        }
    }
}
