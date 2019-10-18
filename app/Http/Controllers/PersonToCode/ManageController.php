<?php

namespace App\Http\Controllers\PersonToCode;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ManageController extends Controller
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
    
    public function index()
    {
        return view('persontocode.index');
    }

    public function postIndex(Request $request)
    {
        $Code   = request('code');
        $Type   = ctype_digit($Code) ? "melli" : "name";
        $Father = request('father');

        // Validation
        try {

            // if (empty($Code) && empty($Father)) {
            //     throw new \Exception('هیچ مقداری ارسال نشده است');
            // }

            $persons = Person::whereNull('code')
                ->where(function ($query) use ($Father, $Code, $Type) {
                    if (!empty($Code)) {
                        $query->where($Type, 'like', '%' . $Code . '%');
                    }

                    if (!empty($Father)) {
                        $query->where('father', 'like', '%' . $Father . '%');
                    }
                })
                ->take(50)
                ->get();

            if ($persons->count() == 0) {
                throw new \Exception("هیچ زائری بدون کد تردد پیدا نشد");
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json([
            'success'  => '',
            'persons'  => $persons,
            // 'personinfo' => View::make('components.persontocode-list', ['persons' => $persons])->render(),
        ]);
    }
}
