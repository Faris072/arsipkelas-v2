<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
                ['id' => 1, 'uuid' => Str::uuid(), 'role_id' => 1, 'name' => 'Developer', 'username' => 'developer', 'email' => 'farisbos.mfs@gmail.com', 'phone' => '085706389042', 'password' => bcrypt('Faris072')],
                ['id' => 2, 'uuid' => Str::uuid(), 'role_id' => 2, 'name' => 'Administrator', 'username' => 'admin', 'email' => 'mufashadesu@gmail.com', 'phone' => '085706389043', 'password' => bcrypt('Faris072')],
                ['id' => 3, 'uuid' => Str::uuid(), 'role_id' => 2, 'name' => 'Administrator 2', 'username' => 'admin2', 'email' => 'mufashadesu2@gmail.com', 'phone' => '085706389044', 'password' => bcrypt('Faris072')],
            ];

            foreach($data as $d){
                $validate = ['username' => $d['username'], 'email' => $d['email'], 'phone' => $d['phone']];
                User::updateOrInsert($validate,$d);
            }

            //alter sequence
            //ketika di seeder mengassign id maka sequence di pgsql tidak dijalankan jadi harus set sequence ke id terakhir+1
            $lastId = User::latest('id')->first()->id;
            $newLastId = $lastId + 1;
            DB::update(DB::raw("ALTER SEQUENCE users_id_seq RESTART {$newLastId}"));

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            echo $e;
        }
    }
}
