<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\InvitationStatus;
use Illuminate\Support\Str;

class InvitationStatusSeeder extends Seeder
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
                ['id' => 1, 'uuid' => Str::uuid(), 'slug' => 'accept', 'name' => 'Accept'],
                ['id' => 2, 'uuid' => Str::uuid(), 'slug' => 'pending', 'name' => 'Pending'],
                ['id' => 3, 'uuid' => Str::uuid(), 'slug' => 'reject', 'name' => 'Reject'],
            ];

            foreach($data as $d){
                $validation = ['id' => $d['id'], 'slug' => $d['slug']];
                InvitationStatus::updateOrInsert($d);
            }

            //alter sequence
            $lastId = InvitationStatus::latest('id')->first()->id;
            $newLastId = $lastId + 1;
            DB::update(DB::raw("ALTER SEQUENCE invitation_statuses_id_seq RESTART {$newLastId}"));

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            echo $e;
        }
    }
}
