<?php

namespace App\Http\Controllers\Importer;

use App\Helpers\ImporterHelper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Modirkarevan;
use App\Models\Person;
use Illuminate\Http\Request;

class ManageController extends Controller
{
	public function __construct()
    {
        $this->middleware(function($req, $next){
            if (!\RBAC::hasAnyPerm('ورود اطلاعات')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }
    
    public function index()
    {
        return view('importer.index');
    }
}
