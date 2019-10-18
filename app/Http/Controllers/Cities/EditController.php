<?php

namespace App\Http\Controllers\Cities;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('مدیریت اسامی شهر ها')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    public function postIndex(Request $request, City $city)
    {
        $input = $request->validate([
            'name' => 'required|unique:cities,name,' . $city->id,
        ]);

        $city->update($input);

        return back()->with('success', 'با موفقیت ویرایش شد');
    }
}
