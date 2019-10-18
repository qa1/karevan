<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ManageController extends Controller
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

    public function index()
    {
        return view('messages.index');
    }

    public function anyData(Request $request)
    {
        $Messages = Message::with('person');

        // Apply Filter
        switch ($request->filter) {
            case "خوانده نشده":
            case "خوانده شده":
                $Messages->where('status', $request->filter);
                break;
        }

        return Datatables::of($Messages)
	        ->addColumn('action', function ($item) {
                $items   = [];
                $items[] = '<li><a href="#" onclick="return false;" data-id="' . $item->id . '" class="details-control"><i class="fa fa-eye"></i> مشاهده پیام</a></li>';

                if ($item->status == 'خوانده شده') {
                    $items[] = '<li><a href="'.route('messages.unread', $item).'"><i class="fa fa-eye-slash"></i> تغییر به خوانده نشده</a></li>';
                } else {
                    $items[] = '<li><a href="'.route('messages.readed', $item).'"><i class="fa fa-eye"></i> تغییر به خوانده شده</a></li>';
                }

                $items[] = '<li><a href="'.route('messages.edit', $item).'"><i class="fa fa-pencil"></i> ویرایش</a></li>';
                $items[] = '<li><a href="'.route('messages.delete', $item).'" onclick="return confirm(\'آیا اطمینان دارید؟\')" href="'.route('users.delete', [$item]).'"><i class="fa fa-trash"></i> حذف</a></li>';

            	$output = '<div class="dropdown">
					<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
					<span class="fa fa-cogs"></span></button>
					<ul class="dropdown-menu dropdown-menu-right">'.implode("\n", $items).'</ul>
				</div>';

				return $output;
            })
            ->addColumn('status', function ($model) {
                return $model->isRead() ? "<span class='label label-success'>خوانده شده</span>" : "<span class='label label-default'>خوانده نشده</span>";
            })
            ->addColumn('message', function ($model) {
                return str_limit(strip_tags($model->message), 30);
            })
            ->addColumn('created_at', function ($model) {
                return $model->created_at->diffForHumans();
            })
            ->make(true);
    }

    /**
     * Message info
     */
    public function messageInfo()
    {
        $model = Message::findOrFail(request('id'));
        return view('components.message-info-ajax', compact('model'));
    }

    /**
     * Delete a message
     */
    public function remove($id)
    {
        Message::findOrFail($id)->delete();
        return back()->with('success', 'پیام با موفقیت حذف شد');
    }

    /**
     * Taghire vaziyat be khaande shode ( masalan baraye taghir vaziyat az tarighe taradod )
     */
    public function readed($id)
    {
        Message::findOrFail($id)->update([
            'status' => 'خوانده شده'
        ]);

        if (request()->ajax()) {
            return response()->json(['type' => 'success']);
        }
        
        return back()->with('success', 'وضعیت با موفقیت تغییر یافت');
    }

    /**
     * Taghire vaziyat be khaande nashode
     */
    public function unread($id)
    {
        Message::findOrFail($id)->update([
            'status' => 'خوانده نشده'
        ]);

        if (request()->ajax()) {
            return response()->json(['type' => 'success']);
        }
        
        return back()->with('success', 'وضعیت با موفقیت تغییر یافت');
    }
}
