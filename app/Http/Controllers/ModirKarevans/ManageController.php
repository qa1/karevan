<?php

namespace App\Http\Controllers\ModirKarevans;

use App\Http\Controllers\Controller;
use App\Models\Modirkarevan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('مدیریت اسامی مدیران کاروان ها')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index()
    {
        return view('modirkarevans.index');
    }

    public function anyData()
    {
        $Modirs = Modirkarevan::query();

        return Datatables::of($Modirs)
            ->addColumn('created_at', function ($model){
                return jDate("Y/m/d H:i:s", $model->created_at->timestamp);
            })
            ->addColumn('action', function ($model) {
                $items   = [];
                $items[] = '<li><a href="'.route('modirkarevans.edit', $model).'"><i class="fa fa-pencil"></i> ویرایش</a></li>';
                $items[] = '<li><a href="'.route('modirkarevans.delete', $model).'" onclick="return confirm(\'آیا اطمینان دارید؟\')"><i class="fa fa-trash"></i> حذف</a></li>';

                $output = '<div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cogs"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">'.implode("\n", $items).'</ul>
                </div>';

                return $output;
            })
            ->make(true);
    }

    public function remove(Modirkarevan $modir)
    {
        $modir->delete();
        return back()->with('success', 'مدیر کاروان با موفقیت حذف شد');
    }

    public function create()
    {
        return view('modirkarevans.create');
    }

    public function postCreate(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|unique:modirkarevans,name',
        ]);

        Modirkarevan::create($input);

        return back()->with('success', 'با موفقیت ایجاد شد');
    }

    public function edit(Modirkarevan $modirkarevan)
    {
        return view('modirkarevans.edit', compact('modirkarevan'));
    }

    public function postEdit(Request $request, Modirkarevan $modirkarevan)
    {
        $input = $request->validate([
            'name' => 'required|unique:modirkarevans,name,' . $modirkarevan->id,
        ]);

        $modirkarevan->update($input);

        return back()->with('success', 'با موفقیت ویرایش شد');
    }
}
