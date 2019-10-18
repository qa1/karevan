<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TaradodController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('ثبت تردد زائر')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index()
    {
        return view('taradod.index');
    }

    public function postIndex(Request $request)
    {
        $code = preg_replace("/[^0-9]/", "", $request->code);
        $type = $request->type == "داخل" ? "داخل" : "خارج";

        // Input Validation
        try {
            if (empty($code)) {
                throw new \Exception("هیچ کدی ارسال نشده است");
            }

            $person = Person::where('code', $code)->orWhere('melli', $code)->first();

            if (!$person) {
                throw new \Exception("زائری با کد وارد شده یافت نشد - " . $code);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        // Zaer Validation
        try {
            // Ban
            if (!is_null($person->ban)) {
                $person->addError('مسدود');
                throw new \Exception("");
            }

            // Status
            if ($type == "داخل") {
                if ($person->isIn()) {
                    $person->addError('ورود');
                    throw new \Exception("خطای ورود. زائر قبلا وارد شده است");
                }
            } else {
                if (!$person->isIn()) {
                    $person->addError('خروج');
                    throw new \Exception("خطای خروج. زائر قبلا خارج شده است");
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'error'      => $e->getMessage(),
                'personinfo' => View::make('components.personinfo-ajax', compact('person'))->render(),
            ]);
        }

        // Sabte Taradod
        $person->newTraffic($type);

        return response()->json([
            'success'    => ($type == "داخل" ? "ورود" : "خروج") . ' با موفقیت ثبت شد',
            'personinfo' => View::make('components.personinfo-ajax', compact('person'))->render(),
        ]);
    }
}
