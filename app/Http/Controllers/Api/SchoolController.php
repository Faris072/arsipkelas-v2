<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\School;

class SchoolController extends Controller
{
    public function createSchool(Request $request){
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
                return $this->getResponse('',$validatedData->getMessage(),422);
            }

            $school = School::create($request->all());
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse('',$e->getMessage(),500);
        }
    }
}
