<?php

namespace App\Http\Controllers\Importer;

use App\Helpers\ImporterHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarresiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($req, $next) {
            if (!\RBAC::hasAnyPerm('ورود اطلاعات')) {
                return redirect()->route('dashboard')->with('error', 'دسترسی غیر مجاز');
            }

            return $next($req);
        });
    }

    public function index(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file;

        if (!in_array(strtolower($file->getClientOriginalExtension()), ['xlsx', 'csv'])) {
            return back()->with('error', 'فرمت فایل معتبر نیست');
        }

        $filePath = public_path('storage/' . $file->store('importer'));

        session([
            "importer_file"   => $filePath,
            "importer_vorood" => $request->vorood ? true : false,
            "importer_reset"  => $request->reset ? true : false,
        ]);

        $validInvalidRows = (new ImporterHelper($filePath, session('importer_reset')))->run();

        return view('importer.barresi', [
            'FileName' => $file->getClientOriginalName(),
            'FilePath' => $filePath,
            'Valid'    => $validInvalidRows['valid'],
            'Invalid'  => $validInvalidRows['invalid'],
        ]);

    }
}
