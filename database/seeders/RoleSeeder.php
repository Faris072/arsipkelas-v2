<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
                ['id' => 1, 'uuid' => Str::uuid(), 'slug' => 'developer', 'name' => 'Developer'],
                ['id' => 2, 'uuid' => Str::uuid(), 'slug' => 'admin', 'name' => 'Admin'],
                ['id' => 3, 'uuid' => Str::uuid(), 'slug' => 'user', 'name' => 'User'],
            ];

            foreach($data as $d){
                $validate = ['slug' => $d['slug'], 'name' => $d['name']];
                Role::updateOrInsert($validate, $d);
            }

            //alter sequence
            $lastId = Role::latest('id')->first()->id;
            $newLastId = $lastId + 1;
            DB::update(DB::raw("ALTER SEQUENCE roles_id_seq RESTART {$newLastId}"));

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            echo $e;
        }
    }
}
