<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\School;
use App\Models\UserSchool;

class SchoolController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $attributes = [
                'name' => 'Nama sekolah',
                'phone' => 'Nomor telepon',
                'email' => 'Email',
                'address' => 'Alamat',
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong.',
                'string' => ':attribute harus berupa string.',
                'email' => ':attribute tidak valid.',
            ];

            $validatedData = Validator::make($request->all(),[
                'name' => 'required|string',
                'phone' => 'required',
                'email' => 'required|email',
                'address' => 'required'
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollback();
                return $this->getResponse('',$validatedData->getMessage(),422);
            }

            $request['is_active'] = true;

            $school = School::create($request->only(['name','phone','email','address','is_active']));
            if(!$school){
                DB::rollback();
                return $this->getResponse(null,'Sekolah gagal dibuat.',500);
            }

            $userSchool = UserSchool::create([
                'user_id' => auth()->user()->id,
                'school_id' => $school->id,
                'school_role_id' => 1,
                'jabatan' => 'Administrator',
                'is_active' => true,
            ]);
            if(!$userSchool){
                DB::rollback();
                return $this->getResponse(null,'User school gagal dibuat',500);
            }

            DB::commit();
            return $this->getResponse(null,'Sekolah berhasil ditambahkan.', 200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse('',$e->getMessage(),500);
        }
    }

    public function update(Request $request, $id){
        DB::beginTransaction();
        try{
            $attributes = [

            ];
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse('',$e->getMessage(),500);
        }
    }
}
