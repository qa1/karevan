<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Error;
use App\Models\Karevan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use \Charts;

class TaradodController extends Controller
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
        $Result = DB::query()
            ->from('traffics')
            ->select([
                DB::raw('type'),
                DB::raw('count(*) as count'),
                DB::raw('date(created_at) as date')
            ])
            ->groupBy([
                DB::raw('type'),
                DB::raw('date(created_at)')
            ])
            ->get();

        $chart = Charts::multi('bar', 'fusioncharts')
            ->setTitle('ورود و خروج به تفکیک روز')
            ->setElementLabel('')
            ->setLabels(array_map(function($row){ return jDate('Y-m-d', strtotime($row)); }, $Result->pluck('date')->unique()->toArray()))
            ->setColors(["#0073b7", "#00a65a"])
            ->setResponsive(true);

        $Data = [
            'داخل'  => [],
            'خارج'  => [],
        ];

        foreach ($Result as $Row) {
            $Data[$Row->type][]  = $Row->count;
        }

        $chart->setDataset("خروج", $Data['خارج']);
        $chart->setDataset("ورود", $Data['داخل']);

        return view('report.taradod', compact('chart'));
    }
}
