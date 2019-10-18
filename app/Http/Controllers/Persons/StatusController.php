<?php

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StatusController extends Controller
{
	public function __construct()
	{
		$this->middleware(function($req, $next){
			if (!\RBAC::hasAnyPerm('جستجوی زائر')) {
				return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
			}

			return $next($req);
		});
	}

    public function index()
    {
        // To Remove Url Param
        if (request('id') != "") {
            session(['status_id' => request('id')]);
            return redirect()->route('status.index');
        }

        // Search
        if (($id = session()->pull('status_id'))) {
            $Person = \App\Models\Person::find($id);
        } else {
            $Person = false;
        }

        return view('status.index', ['person' => $Person]);
    }

    public function postIndex(Request $request)
    {
        $code = preg_replace("/[^0-9]/", "", $request->code);
        
        // Validation
        try {

            if (empty($code)) {
                throw new \Exception("هیچ کدی ارسال نشده است");
            }

            $person = Person::where('code', $code)->orWhere('melli', $code)->first();

            if (!$person) {
                throw new \Exception("زائری با کد وارد شده یافت نشد");
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success'    => '',
            'personinfo' => View::make('components.personinfo-ajax', compact('person'))->render()
        ]);
    }
}
