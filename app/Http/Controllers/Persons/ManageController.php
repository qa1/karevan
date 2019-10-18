<?php

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($req, $next) {
            if (!\RBAC::hasAnyPerm('مدیریت زائرین')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index()
    {
        return view('persons.index');
    }

    public function datatable(Request $request)
    {
        $query = Person::with('city', 'modirkarevan');
        $query->orderBy('id', 'desc');

        // Apply Filter
        switch ($request->filter) {
            case "داخل":
            case "خارج":
            case "مراجعه نشده":
                $query->where('status', $request->filter);
                break;
            case "مسدود":
                $query->whereNotNull('ban');
                break;
        }

        // Other Filters
        if (request('city', 'all') != "all") {
            $query->where('city_id', request('city'));
        }

        if (request('modirkarevan', 'all') != "all") {
            $query->where('modirkarevan_id', request('modirkarevan'));
        }

        return Datatables::of($query)
            ->addColumn('action', function ($item) {
                $items = [];
                if (!is_null($item->ban)) {
                    $items[] = '<li><a href="' . route('persons.clearban', $item) . '"><i class="fa fa-check"></i> رفع مسدودی</a></li>';
                }

                $items[] = '<li><a href="' . route('persons.edit', $item) . '"><i class="fa fa-edit"></i> ویرایش</a></li>';
                $items[] = '<li><a href="' . route('persons.message', $item) . '"><i class="fa fa-envelope"></i> ارسال پیام</a></li>';
                $items[] = '<li><a href="#" onclick="return false;" data-id="' . $item->id . '" class="details-control"><i class="fa fa-eye"></i> مشاهده اطلاعات</a></li>';
                $items[] = '<li><a href="' . route('status.index', ['id' => $item->id]) . '"><i class="fa fa-search"></i> وضعیت</a></li>';
                $items[] = '<li><a href="' . route('persons.delete', $item) . '" onclick="return confirm(\'آیا اطمینان دارید؟\')" href="' . route('users.delete', $item) . '"><i class="fa fa-trash"></i> حذف</a></li>';

                $output = '<div class="dropdown">
					<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
					<span class="fa fa-cogs"></span></button>
					<ul class="dropdown-menu dropdown-menu-right">' . implode("\n", $items) . '</ul>
				</div>';

                return $output;
            })
            ->addColumn('status', function ($person) {
                $output = "<span class='label " . ($person->isIn() ? 'label-success' : 'label-default') . "'>{$person->status}</span>";
                $output .= $person->ban ? "<br/><span class='label label-danger'>مسدود</span>" : "";
                return $output;
            })
            ->addColumn('avatar', function ($person) {
                return '<a href="' . $person->imageUrl() . '" target="_blank"><img src="' . $person->imageThumb() . '" width="50" height="50" class="img-rounded" /></a>';
            })
            ->addColumn('created_at', function ($person) {
                return jDate("Y/m/d - H:i:s", $person->created_at->timestamp);
            })
            ->rawColumns(['action', 'status', 'avatar'])
            ->make(true);
    }

    public function personInfo(Request $request)
    {
        $person = Person::findOrFail($request->id);

        return view('components.person-info-ajax', compact('person'));
    }

    public function remove(Person $person)
    {
        \App\Models\ReportTraffic::todayRecordOrCreate($person->modirkarevan_id)
            ->decrement('current_' . ($person->isIn() ? 'in' : 'out'));

        $person->delete();

        return back()->with('success', 'با موفقیت حذف شد');
    }

    public function clearban(Person $person)
    {
        $person->update(['ban' => null]);

        return back()->with('success', 'با موفقیت رفع مسدودیت شد');
    }
}
