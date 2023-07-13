<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use App\Models\PhotoProfile;
use Illuminate\Support\Facades\Storage;

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
            $request['password'] = bcrypt($request->password);

            $create = User::create($request->only(['username','email','phone','name','password','role_id']));
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

    public function login(Request $request){
        try{
            $user = User::where('username',$request->username)->orWhere('email',$request->username)->orWhere('phone',$request->username)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return $this->getResponse(null,'Authentikasi gagal. Silahkan logiin kembali.',401);
            }

            $token = $user->createToken('arsipkelasv2_token')->plainTextToken;

            $data = [
                'me' => $user,
                'token' => $token
            ];

            return $this->getResponse($data, 'Login berhasil.',200);
        }
        catch(\Exception $e){
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function me(){
        try{
            $user = Auth()->user();
            return $this->getResponse($user,'Data berhasil ditampilkan',200);
        }
        catch(\Exception $e){
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function changePassword(Request $request){
        DB::beginTransaction();
        try{
            $attributes = [
                'new_password' => 'Password baru',
                'confirm_password' => 'Konfirmasi Password'
            ];

            $messages = [
                'required' => 'Tidak boleh kosong',
                'same' => 'Password dan Konfirmasi password harus sama',
                'min' => ':attribute minimal 8 karakter',
            ];

            $validatedData = Validator::make($request->all(),[
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:new_password',
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollback();
                return $this->getResponse(null,$validatedData->getMessageBag(),422);
            }

            if($request->password == $request->new_password){
                DB::rollback();
                return $this->getResponse(null,'Password baru tidak boleh sama dengan password lama',422);
            }

            if(!Hash::check($request->password, auth()->user()->password)){
                DB::rollback();
                return $this->getResponse(null,'Password salah',400);
            };

            $user = User::find(Auth()->user()->id);
            if(!$user){
                DB::rollback();
                return $this->getResponse(null,'User tidak ditemukan',404);
            }

            $change = $user->update([
                'password' => bcrypt($request->new_password)
            ]);

            if(!$change){
                DB::rollback();
                return $this->getResponse(null,'Reset password gagal',500);
            }

            DB::commit();
            return $this->getResponse(null,'Password berhasil diubah',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function logout(){
        try{
            $logout = auth('sanctum')->user()->tokens()->delete();
            if(!$logout){
                return $this->getResponse(null,'Logout gagal',500);
            }

            return $this->getResponse(null,'Logout berhasil',200);
        }
        catch(\Exception $e){
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function resetPassword($id){
        DB::beginTransaction();
        try{
            $user = User::firstWhere('uuid',$id);
            if(!$user){
                DB::rollback();
                return $this->getResponse(null,'User tidak ditemukan.',404);
            }

            $reset = $user->update([
                'password' => bcrypt(config('myconfig.default_password'))
            ]);

            if(!$reset){
                DB::rollback();
                return $this->getResponse(null,'Reset password gagal',500);
            }

            DB::commit();
            return $this->getResponse(null,'Reset Password Berhasil',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function uploadFile(Request $request){
        DB::beginTransaction();
        try{
            $attributes = [
                'file' => 'Foto profil'
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong.',
                'image' => ':attribute harus berhpa gambar.',
                'max' => ':attribute maksimal 1MB.',
                'mimes' => ':attribute harus berupa .jpeg, .jpg, dan .png.',
            ];

            $validatedData = Validator::make($request->all(),[
                'file' => 'required|image|max:1024|mimes:jpeg,jpg,png'
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollBack();
                return $this->getResponse(null,$validatedData->getMessageBag(),422);
            }

            $path = 'profile/'.auth()->user()->id;
            $name = time().random_int(1,100).$request->file->getClientOriginalName();

            $data = [
                'user_id' => auth()->user()->id,
                'name' => $name,
                'original_name' => $request->file->getClientOriginalName(),
                'path' => $path,
                'extension' => $request->file->getClientOriginalExtension(),
                'size' => $request->file->getSize(),
                'mime_type' => $request->file->getMimeType(),
                'is_image' => substr($request->file->getMimeType(), 0, 5) == 'image' ? true : false,
            ];

            $validation = ['user_id' => $data['user_id']];
            $store = PhotoProfile::updateOrCreate($validation,$data);
            if(!$store){
                DB::rollback();
                return $this->getResponse(null,'Profil gagal diperbarui',500);
            }

            $files = Storage::allFiles('profile/'.auth()->user()->id);
            foreach($files as $f){
                Storage::delete($f);
            }

            $request->file->storeAs($path, $data['name']);

            DB::commit();
            return $this->getResponse(null,'Profil berhasil diubah',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }
}
