<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class ManageController extends Controller
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
        return view('users.index');
    }

    public function anyData()
    {
        $Users = User::query();

        return Datatables::of($Users)
            ->addColumn('action', function ($user) {
                $Col = '<div class="btn-group">';
                $Col .= '<a href="' . route('users.edit', $user) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
                $Col .= '<a href="' . route('users.delete', $user) . '" onclick="return confirm(\'آیا اطمینان دارید؟\')" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></a>';
                $Col .= "</div>";
                return $Col;
            })
            ->make(true);
    }

    public function remove(User $user)
    {
        $user->delete();
        return back()->with('success', 'با موفقیت حذف شد');
    }
}
