<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use \Charts;

class ErrorController extends Controller
{
	public function __construct()
	{
		$this->middleware(function($req, $next){
			if (!\RBAC::hasAnyPerm('گزارشات')) {
				return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
			}

			return $next($req);
		});
	}
	
    public function index()
    {
        $Errors = DB::query()
            ->from('errors')
            ->select([
                'message as type',
                DB::raw('count(*) as count'),
            ])
            ->groupBy('message')
            ->get();

        $chart = Charts::create('pie', 'fusioncharts')
            ->setTitle('تعداد خطاها به تفکیک نوع')
            ->setLabels($Errors->pluck('type'))
            ->setValues($Errors->pluck('count'))
            ->setResponsive(true);

        return view('report.error', compact('chart'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $Errors = Error::with('person', 'person.modirkarevan');

        return Datatables::of($Errors)
            ->addColumn('created_at', function ($model) {
                return $model->created_at->diffForHumans() . ' | ' . jDate("Y/m/d - H:i:s", $model->created_at->timestamp);
            })
            ->make(true);
    }
}
