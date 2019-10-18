<?php

namespace App\Http\Controllers\Importer;

use App\Helpers\ImporterHelper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Modirkarevan;
use App\Models\Person;
use Illuminate\Http\Request;

class ImportController extends Controller
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
        $filePath   = session()->pull('importer_file');
        $reset      = session()->pull('importer_reset', false);
        $newTraffic = session()->pull('importer_vorood', false);

        if (empty($filePath) || !is_file($filePath)) {
            return redirect()
                ->route('importer')
                ->with('error', 'هیچ فایلی پیدا نشد');
        }

        $ValidInvalidRows = (new ImporterHelper($filePath, $reset))->run();
        $Valid            = $ValidInvalidRows['valid'];

        if ($Valid->count() == 0) {
            return redirect()
                ->route('importer')
                ->with('error', 'هیچ سطر معتبری پیدا نشد');
        }

        // Reset Database
        if ($reset) {
            foreach (\App\Models\Modirkarevan::get() as $item) {
                $item->delete();
            }

            foreach (\App\Models\City::get() as $item) {
                $item->delete();
            }

            \Spatie\MediaLibrary\Media::truncate();
        }

        // Delete File
        unlink($filePath);

        // Shahrs
        $shahr = [];
        foreach (collect($Valid)->pluck('city')->unique() as $city) {
            $shahr[$city] = City::firstOrCreate(['name' => $city])->id;
        }

        // Modirkarevans
        $modirkarevan = [];
        foreach (collect($Valid)->pluck('modir')->unique() as $modir) {
            $modirkarevan[$modir] = Modirkarevan::firstOrCreate(['name' => $modir]);
        }

        // Create Report Table
        foreach ($modirkarevan as $item) {
            \App\Models\ReportTraffic::todayRecordOrCreate($item->id)
                ->increment('current_out', collect($Valid)->where('modir', $item->name)->count());
        }

        foreach ($Valid as $Row) {
            // Create Person
            $Person = Person::create([
                'name'            => $Row['name'],
                'father'          => $Row['father'],
                'code'            => $Row['code'] ?: null,
                'melli'           => $Row['melli'] ?: null,
                'city_id'         => $shahr[$Row['city']],
                'modirkarevan_id' => $modirkarevan[$Row['modir']]->id,
            ]);

            // Traffic
            if ($newTraffic) {
                $Person->enter();
            }
        }

        return redirect()->route('importer')
            ->with('success', 'اطلاعات با موفقیت در پایگاه داده ذخیره شد');
    }
}
