<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class EditController extends Controller
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
	
    public function index(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function postIndex(Request $request, User $user)
    {
        $data = $request->validate([
            'name'       => 'required|max:255',
            'username'   => 'required|unique:users,username,' . $user->id,
            'password'   => 'nullable|confirmed',
            'permission' => 'nullable|exists:permissions,id'
        ]);

	    $user->update([
	        'name'      => $data['name'],
	        'username'  => $data['username'],
	        'password'  => empty($data['password']) ? $user->password : \Hash::make($data['password']),
	    ]);

	    $user->syncPermissions(Permission::whereIn('id', $request->permission ?: [])->get());

        return back()->with('success', 'با موفقیت ذخیره شد');
    }
}
