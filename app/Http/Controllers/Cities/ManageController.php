<?php

namespace App\Http\Controllers\Cities;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ManageController extends Controller
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

    public function index()
    {
        return view('cities.index');
    }

    public function anyData()
    {
        $Cities = City::query();

        return Datatables::of($Cities)
            ->addColumn('created_at', function ($model){
                return jDate("Y/m/d H:i:s", $model->created_at->timestamp);
            })
            ->addColumn('action', function ($model) {
                $items   = [];
                $items[] = '<li><a href="'.route('cities.edit', $model).'"><i class="fa fa-pencil"></i> ویرایش</a></li>';
                $items[] = '<li><a href="'.route('cities.delete', $model).'" onclick="return confirm(\'آیا اطمینان دارید؟\')"><i class="fa fa-trash"></i> حذف</a></li>';

                $output = '<div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cogs"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">'.implode("\n", $items).'</ul>
                </div>';

                return $output;
            })
            ->make(true);
    }

    public function remove(City $city)
    {
        $city->delete();
        return back()->with('success', 'با موفقیت حذف شد');
    }

    public function create()
    {
        return view('cities.create');
    }

    public function postCreate(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|unique:cities,name',
        ]);

        City::create($input);

        return back()->with('success', 'با موفقیت ایجاد شد');
    }
}
