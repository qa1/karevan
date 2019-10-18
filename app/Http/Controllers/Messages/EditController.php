<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class EditController extends Controller
{
	public function __construct()
	{
		$this->middleware(function($req, $next){
			if (!\RBAC::hasAnyPerm('مدیریت پیام ها')) {
				return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
			}

			return $next($req);
		});
	}

    public function index(Message $message)
    {
        return view('messages.edit', compact('message'));
    }

    public function postIndex(Request $request, Message $message)
    {
        $input = $request->validate([
            'message' => 'required'
        ]);

        $message->update($input);
        
        return back()->with('success', 'با موفقیت ویرایش شد');
    }
}
