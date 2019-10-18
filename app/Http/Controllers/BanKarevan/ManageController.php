<?php

namespace App\Http\Controllers\BanKarevan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('مسدود کردن کاروان')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index()
    {
        return view('bankarevan.index');
    }

    public function postIndex(Request $request)
    {
        $input = $request->validate([
            'modirkarevan' => 'required|exists:modirkarevans,id',
            'type' => 'required|in:مسدود کردن,رفع مسدودی',
            'message' => 'required_if:type,مسدود کردن',
        ],[], [
            'modirkarevan' => 'کاروان',
            'message' => 'دلیل مسدودیت',
            'type' => 'عملیات'
        ]);

        $modirkarevan = \App\Models\Modirkarevan::find($input['modirkarevan']);
        $tedad = \App\Models\Person::where('modirkarevan_id', $input['modirkarevan'])
            ->update(['ban' => isset($input['message']) ? $input['message'] : NULL]);

        return back()->with('success', 'تعداد ' . $tedad . ' نفر از کاروان ' . $modirkarevan->name . ' با موفقیت ' . ( $input['type'] == 'مسدود کردن' ? 'مسدود شدند' : 'رفع مسدودیت شدند' ));
    }
}
