<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonController extends Controller
{
	public function __construct()
	{
        // Har Min 2 Doone
        // $this->middleware('throttle:2,1');

		$this->middleware(function($req, $next){
			if (!\RBAC::hasAnyPerm('خروجی زائرین')) {
				return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
			}

			return $next($req);
		});
	}

    public function index(Request $request)
    {
        $input = $request->validate([
            'type' => ['required', Rule::in(['html', 'xls', 'xlsx', 'csv', 'txt'])]
        ]);

        $result = \App\Models\Person::with(['city', 'modirkarevan', 'traffic' => function($query){
            $query->orderBy('id', 'asc');
        }])->get();

        \Excel::create(jDate("Y-m-d"), function($excel) use($result) {

            $excel->sheet('زائرین', function($sheet) use($result) {

                $sheet->appendRow([
                    'کد تردد',
                    'کد ملی',
                    'نام و نام خانوادگی',
                    'نام پدر',
                    'وضعیت',
                    'نام شهر',
                    'کاروان',
                    'تعداد ورود',
                    'تعداد خروج',
                    'مسدود',
                    'اولین تردد',
                    'آخرین تردد',
                    'تاریخ عضویت',
                ]);

                foreach($result as $person) {
                    $firstTrafficCol = ($firstTraffic = $person->traffic->first()) ? jDate("Y/m/d H:i:s", $firstTraffic->created_at->timestamp) : '';
                    $lastTrafficCol = ($lastTraffic = $person->traffic->last()) ? jDate("Y/m/d H:i:s", $lastTraffic->created_at->timestamp) : '';

                    $sheet->appendRow([
                        $person->code,
                        $person->melli,
                        $person->name,
                        $person->father,
                        $person->status,
                        $person->city->name,
                        $person->modirkarevan->name,
                        $person->traffic->where('type', 'داخل')->count(),
                        $person->traffic->where('type', 'خارج')->count(),
                        $person->ban,
                        $firstTrafficCol,
                        $lastTrafficCol,
                        jDate("Y/m/d H:i:s", $person->created_at->timestamp),
                    ]);
                }

            });

        })->download($input['type']);
    }
}
