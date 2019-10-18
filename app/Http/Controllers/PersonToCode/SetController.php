<?php

namespace App\Http\Controllers\PersonToCode;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('ارتباط زائر با کد تردد')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index(Request $request)
    {
        $validator = validator($request->all(), [
            'id'   => 'required|exists:persons,id',
            'code' => 'required|numeric|unique:persons,code',
        ], [], [
            'code' => 'کد تردد',
            'id'   => 'شماره زائر',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $person = Person::find($request->id);

        if (!is_null($person->code)) {
            return response()->json(['error' => 'برای این زائر قبلا کد تررد تعریف شده است']);
        }

        $person->update([
            'code' => $request->code
        ]);

        // Image
        if (!empty($request->image)) {
            if ($person->getFirstMedia()) {
                $person->getFirstMedia()->delete();
            }

            $file = base64ImageToUploadedFile($request->image);
            $person->copyMedia($file)->toMediaCollection();
            @unlink($file->getRealPath());
        }

        // Taradod
        if ($request->taradod != '' && in_array($request->taradod, ['داخل', 'خارج'])) {
            if ($request->taradod == "داخل") {
                if (!$person->isIn()) {
                    $person->newTraffic($request->taradod);
                }
            } else {
                if ($person->isIn()) {
                    $person->newTraffic($request->taradod);
                }
            }
        }

        return response()->json([
            'success' => 'کد تردد با موفقیت ثبت شد' . ( empty($person->name) ? "" : ' - ' . $person->name )
        ]);
    }
}
