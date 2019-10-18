<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use \Datatables;
use \RBAC;
use \Auth;

class PermissionsController extends Controller
{
	public function __construct()
	{
		// $this->middleware(function($request, $next){
		// 	if (!RBAC::isAdmin()) {
		// 		return redirect()->route('dashboard');
		// 	}

		// 	return $next($request);
		// });
	}

    public function index()
    {
        return view('rbac.permissions.index');
    }

    /**
     * Data for datatables
     * @return json
     */
    public function datatable()
    {
        return Datatables::eloquent(Permission::query())
        	->addColumn('created_at', function ($item){
        		return jDate("Y/m/d - H:i:s", $item->created_at->timestamp);
        	})
            ->addColumn('action', function ($item) {
                $col = '<div class="btn-group">';
                $col .= '<a href="' . route('rbac.permissions.delete', [$item]) . '" class="btn btn-xs btn-warning" onclick="return confirm(\'آیا اطمینان دارید؟\')"><i class="fa fa-trash"></i></a>';
                $col .= '<a href="' . route('rbac.permissions.edit', [$item]) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
                $col .= '</div>';
                return $col;
            })
            ->make(true);
    }

    /**
     * Create page
     */
    public function create(Request $request)
    {
        return view('rbac.permissions.create');
    }

    /**
     * Handle Create Request
     */
    public function postCreate(Request $request)
    {
        Permission::create($request->validate([
        	'name' => 'required|unique:permissions,name'
        ]));

        return back()->with('success', 'با موفقیت ایجاد شد');
    }

    /**
     * Edit page
     */
    public function edit(Permission $permission)
    {
        return view('rbac.permissions.edit', compact('permission'));
    }

    /**
     * Handle Edit Request
     */
    public function postEdit(Permission $permission, Request $request)
    {
        $permission->update($request->validate([
        	"name" => "required|unique:permissions,name,{$permission->id}",
        ]));

        return back()->with('success', 'با موفقیت ویرایش شد');
    }

    /**
     * Delete
     */
    public function delete(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'با موفقیت حذف شد');
    }
}
