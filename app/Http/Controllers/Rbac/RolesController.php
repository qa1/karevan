<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \Datatables;
use \RBAC;
use \Auth;

class RolesController extends Controller
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
        return view('rbac.roles.index');
    }

    /**
     * Data for datatables
     * @return json
     */
    public function datatable()
    {
        return Datatables::eloquent(Role::query())
            ->addColumn('action', function ($item) {
                $col = '<div class="btn-group">';
                $col .= '<a href="' . route('rbac.roles.delete', [$item]) . '" class="btn btn-xs btn-warning" onclick="return confirm(\'آیا اطمینان دارید؟\')"><i class="fa fa-trash"></i></a>';
                $col .= '<a href="' . route('rbac.roles.edit', [$item]) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
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
        $permissions = Permission::get();
        return view('rbac.roles.create', compact('permissions'));
    }

    /**
     * Handle Create Request
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if (is_array($request->permission)) {
            $role->givePermissionTo(Permission::whereIn('id', $request->permission)->get());
        }

        return redirect()->route('rbac.roles.edit', $role)->with('success', 'با موفقیت ایجاد شد');
    }

    /**
     * Edit page
     */
    public function edit(Role $role)
    {
    	$permissions = Permission::get();
        return view('rbac.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Handle Edit Request
     */
    public function postEdit(Role $role, Request $request)
    {
        $this->validate($request, [
            'name' => "required|unique:roles,name,{$role->id}",
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        // Revoke All Permissions
        foreach(Permission::get() as $permission) {
        	$role->revokePermissionTo($permission);
        }

        if (is_array($request->permission)) {
            $role->givePermissionTo(Permission::whereIn('id', $request->permission)->get());
        }

        return back()->with('success', 'با موفقیت ویرایش شد');
    }

    /**
     * Delete
     */
    public function delete(Role $role)
    {
        $role->delete();

        return back()->with('success', 'با موفقیت حذف شد');
    }
}
