<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Charts;

class KarevanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($req, $next) {
            if (!\RBAC::hasAnyPerm('گزارشات')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index(Request $request)
    {
        $allDates = array_keys(trafficsDates());
        $date     = $request->date ?: (count($allDates) ? array_pop($allDates) : '');
        $result   = \App\Models\ReportTraffic::with('modirkarevan')
            ->whereDate('created_at', $date)
            ->get();

        $chart = Charts::multi('bar', 'fusioncharts')
            ->setTitle('آمار و وضعیت زائرین کاروان ها')
            ->setElementLabel('')
            ->setLabels($result->pluck('modirkarevan.name'))
        // ->setHeight(500)
            ->setColors(["#00a65a", "#f05b4f", "#f4c63d"])
            ->setResponsive(true);

        $Data = [
            'in'   => [],
            'out'  => [],
            'none' => [],
            'all'  => [],
        ];

        foreach ($result as $item) {
            $none = \App\Models\Person::where("modirkarevan_id", $item->modirkarevan_id)->whereStatus("مراجعه نشده")->count();

            $Data['all'][]  = $item->current_in + $item->current_out + $none;
            $Data['in'][]   = $item->current_in;
            $Data['out'][]  = $item->current_out;
            $Data['none'][] = $none;
        }

        $chart->setDataset("داخل", $Data['in']);
        $chart->setDataset("خارج", $Data['out']);
        $chart->setDataset("مراجعه نشده", $Data['none']);
        $chart->setDataset("کل", $Data['all']);

        return view(
            'report.karevan',
            [
                'chart'    => $chart,
                'date'     => $date,
                'karevans' => $result->pluck('modirkarevan.name'),
                'data'     => $Data,
            ]
        );
    }
}
