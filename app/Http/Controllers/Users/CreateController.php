<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class CreateController extends Controller
{
	public function __construct()
	{
		$this->middleware(function($req, $next){
			if (!\RBAC::hasAnyPerm('مدیریت کاربران')) {
				return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
			}

			return $next($req);
		});
	}
	
    public function index()
    {
        return view('users.create');
    }

    public function postIndex(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|max:255',
            'username'   => 'required|unique:users',
            'password'   => 'required|confirmed',
            'permission' => 'nullable|exists:permissions,id',
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'username'  => $data['username'],
            'password'  => \Hash::make($data['password']),
        ]);

        $user->syncPermissions(Permission::whereIn('id', $request->permission ?: [])->get());

        return back()->with('success', 'با موفقیت ایجاد شد');
    }
}
