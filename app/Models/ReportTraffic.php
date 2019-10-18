<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTraffic extends Model
{
    protected $guarded = [];
    protected $table   = 'report_traffic';

    public function modirkarevan()
    {
        return $this->belongsTo(\App\Models\Modirkarevan::class);
    }

    public static function newRecord($modirkarevan_id)
    {
        return \App\Models\ReportTraffic::create([
            'modirkarevan_id' => $modirkarevan_id,
            'current_in'      => \App\Models\Person::where('modirkarevan_id', $modirkarevan_id)->where('status', 'داخل')->count(),
            'current_out'     => \App\Models\Person::where('modirkarevan_id', $modirkarevan_id)->where('status', 'خارج')->count(),
        ]);
    }

    public static function todayRecord($modirkarevan_id)
    {
        $model = \App\Models\ReportTraffic::where('modirkarevan_id', $modirkarevan_id)
            ->whereDate('created_at', date("Y-m-d"))
            ->first();

        if (!$model) {
            return false;
        }

        return $model;
    }

    public static function todayRecordOrCreate($modirkarevan_id)
    {
        $model = \App\Models\ReportTraffic::where('modirkarevan_id', $modirkarevan_id)
            ->whereDate('created_at', date("Y-m-d"))
            ->first();

        if (!$model) {
            return self::newRecord($modirkarevan_id);
        }

        return $model;
    }
}
