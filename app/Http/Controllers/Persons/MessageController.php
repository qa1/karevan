<?php

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('مدیریت زائرین')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index(Person $person)
    {
        return view('persons.sendmessage', compact('person'));
    }

    public function postIndex(Request $request, Person $person)
    {
        $data = $request->validate([
        	'message' => 'required|max:255'
        ]);

        $person->messages()->create($data);

        return back()->with('success', 'با موفقیت ثبت شد');
    }
}
