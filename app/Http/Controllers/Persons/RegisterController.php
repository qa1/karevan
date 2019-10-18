<?php

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Modirkarevan;
use App\Models\Person;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('ثبت نام زائر')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index()
    {
        return view('persons.register');
    }

    public function postIndex(Request $request)
    {
        $request->validate([
            'code'            => 'required|numeric|unique:persons,code',
            'melli'           => 'sometimes|numeric|unique:persons,melli',
            'city_id'         => 'required_without:city_name',
            'modirkarevan_id' => 'required_without:modirkarevan_name',
            'melli'           => 'nullable|numeric'
        ], [], [
            'city_name'         => 'شهر جدید',
            'modirkarevan_name' => 'مدیر کاروان جدید',
            'modirkarevan_id'   => 'مدیر کاروان'
        ]);

        // Person
        $model = \App\Models\Person::create([
            'code'            => $request->code,
            'melli'           => $request->melli,
            'name'            => $request->name,
            'father'          => $request->father,
            'city_id'         => $request->city_name ? getCityOrCreate($request->city_name)->id : $request->city_id,
            'modirkarevan_id' => $request->modirkarevan_name ? getModirKarevanOrCreate($request->modirkarevan_name)->id : $request->modirkarevan_id
        ]);

        // Image
        if (!empty($request->person_camera_data)) {
            $file = base64ImageToUploadedFile($request->person_camera_data);
            $model->copyMedia($file)->toMediaCollection();
            @unlink($file->getRealPath());
        }

        // ReportTraffic
        // Agar today record vojood dasht, bayad yeki be out ezafe konim be in dalil ke
        // vaghti new sakhte mishe tedado hesab mikone va tedad doroste age inc konim 1 doone
        // ezafe mishe
        if($todayRecord = \App\Models\ReportTraffic::todayRecord($model->modirkarevan_id)) {
            $todayRecord->increment('current_out');
        } else {
            \App\Models\ReportTraffic::newRecord($model->modirkarevan_id);
        }

        // Taradod
        if ($request->vorood != "") {
            $model->newTraffic("داخل");
        }

        return response()->json([
            'type'    => 'success',
            'message' => 'با موفقیت ایجاد شد'
        ]);
    }
}
