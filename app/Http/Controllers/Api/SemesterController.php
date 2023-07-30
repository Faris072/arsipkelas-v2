<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Semester;
use App\Models\School;

class SemesterController extends Controller
{
    public function createSemester(Request $request){
        DB::beginTransaction();
        try{
            $attributes = [
                'school_id' => 'Sekolah',
                'name' => 'Nama semester',
                'year' => 'Tahun semester',
            ];

            $messages = [
                'required' => ':attribute wajib di isi.',
                'uuid' => 'ID :attribute tidak valid',
                'numeric' => ':attribute harus berupa numeric.',
                'string' => ':attribute harus berupa teks.'
            ];

            $validatedData = Validator::make($request->all(), [
                'school_id' => 'required|uuid|exists:schools,uuid',
                'name' => 'string|required',
                'year' => 'required|numeric'
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollback();
                return $this->getResponse(null,$validatedData->getMessageBag(),422);
            }

            $check = Semester::with(['school'])
                ->whereHas('school', function($q) use ($request){
                    $q->where('uuid', $request->school_id);
                })
                ->where('slug',$request->name)
                ->where('year',$request->year)->first();
            if($check){
                DB::rollback();
                return $this->getResponse(null,'Data semester sudah ada.',400);
            }

            $school = School::firstWhere('uuid', $request->school_id);

            $name = $request->name ?? '';
            switch($name){
                case 'ganjil':
                    $name = 'Ganjil';
                    break;
                case 'genap':
                    $name = 'Genap';
                    break;
                default:
                    $name = null;
                    break;
            }

            $create = Semester::create([
                'school_id' => $school->id,
                'slug' => $request->name,
                'name' => $name,
                'year' => $request->year,
            ]);
            if(!$create){
                DB::rollback();
                return $this->getResponse(null,'Tambah semester gagal.',500);
            }

            DB::commit();
            return $this->getResponse(null,'Semester berhasil disimpan.',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function updateSemester(Request $request, $semesterId){
        DB::beginTransaction();
        try{
            $request['uuid'] = $semesterId;

            $attributes = [
                'uuid' => 'ID Semester',
                'school_id' => 'Sekolah',
                'name' => 'Nama semester',
                'year' => 'Tahun semester',
            ];

            $messages = [
                'required' => ':attribute wajib di isi.',
                'uuid' => 'ID :attribute tidak valid',
                'numeric' => ':attribute harus berupa numeric.',
                'string' => ':attribute harus berupa teks.'
            ];

            $validatedData = Validator::make($request->all(), [
                'uuid' => 'uuid|required|exists:semesters,uuid',
                'school_id' => 'required|uuid|exists:schools,uuid',
                'name' => 'string|required',
                'year' => 'required|numeric'
            ],$messages,$attributes);

            if($validatedData->fails()){
                DB::rollback();
                return $this->getResponse(null,$validatedData->getMessageBag(),422);
            }

            $check = Semester::with(['school'])
                ->whereHas('school', function($q) use ($request){
                    $q->where('uuid', $request->school_id);
                })
                ->where('slug',$request->name)
                ->where('year',$request->year)->first();
            if($check){
                DB::rollback();
                return $this->getResponse(null,'Data semester sudah ada.',400);
            }

            $school = School::firstWhere('uuid', $request->school_id);

            $name = $request->name;
            switch($name){
                case 'ganjil':
                    $name = 'Ganjil';
                    break;
                case 'genap':
                    $name = 'Genap';
                    break;
                default:
                    $name = null;
                    break;
            }

            $update = Semester::find(Semester::firstWhere('uuid',$semesterId)->id)->update([
                'school_id' => $school->id,
                'slug' => $request->name,
                'name' => $name,
                'year' => $request->year,
            ]);
            if(!$update){
                DB::rollback();
                return $this->getResponse(null,'Tambah semester gagal.',500);
            }

            DB::commit();
            return $this->getResponse(null,'Semester berhasil disimpan.',200);
        }
        catch(\Exception $e){
            DB::rollback();
            return $this->getResponse(null,$e->getMessage(),500);
        }
    }

    public function deleteSemester($semesterId){
        DB::beginTransaction();
        try{
            $semester = Semester::firstWhere('uuid', $semesterId);
            if(!$semester){
                DB::rollback();
                return $this->getResponse(null,'Semester tidak ditemukan.', 404);
            }

            $delete = $semester->delete();
            if(!$delete){
                DB::rollBack();
                return $this->getResponse(null,'Semester gagal dihapus',500);
            }

            DB::commit();
            return $this->getResponse(null,'Semester berhasil dihapus',200);
        }
        catch(\Exception $e){
            DB::rollBack();
            return $this->getResponse(null, $e->getMessage(),500);
        }
    }
}
