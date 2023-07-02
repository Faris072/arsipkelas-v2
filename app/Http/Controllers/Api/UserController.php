<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
        DB::beginTransaction();
        try{
            $attributes = [
                'name' => 'Nama',
                'username' => 'Username',
                'email' => 'Email',
                'phone' => 'Nomor Telepon',
                'password' => 'Password',
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong.',
                'uuid' => 'Id :attribute tidak valid.',
                'email' => ':attribute tidak valid.',
                'username.min' => ':attribute minimal 3 karakter.',
                'password.min' => ':attribute minimal 8 karakter.',
                'unique' => ':attribute sudah ada.'
            ];

            $validatedData = Validator::make($request->all(),[
                'name' => 'required',
                'username' => 'required|min:3|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:8'
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollback();
                return $this->getResponse('',$validatedData->getMessageBag(),422);
            }

            $request['role_id'] = 3;

            $create = User::create($request->all());
            if(!$create){
                DB::rollBack();
                return $this->getResponse('','User gagal dibuat',500);
            }

            DB::commit();
            return $this->getResponse('','User berhasil dibuat',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse('',$e->getMessage(),500);
        }
    }
}
