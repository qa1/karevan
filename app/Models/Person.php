<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Person extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table   = "persons";
    protected $with    = ['media'];
    protected $guarded = [];

    /**
     * Media
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(120)->height(120);
    }

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function modirkarevan()
    {
        return $this->belongsTo(\App\Models\Modirkarevan::class);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function error()
    {
        return $this->hasMany(\App\Models\Error::class);
    }

    public function traffic()
    {
        return $this->hasMany(\App\Models\Traffic::class);
    }

    /**
     * Helpers
     */
    public function isIn()
    {
        return $this->status == "داخل";
    }

    public function hasImage()
    {
        return $this->getFirstMedia() ? true : false;
    }

    public function imageThumb()
    {
        if (!$this->hasImage()) {
            return '/images/avatar.png';
        }

        $media = $this->getFirstMedia();
        return $media->getUrl('thumb') . '?r=' . md5($media->created_at);
    }

    public function imageUrl()
    {
        if (!$this->hasImage()) {
            return '/images/avatar.png';
        }

        $media = $this->getFirstMedia();
        return $media->getUrl() . '?r=' . md5($media->created_at);
    }

    public function newTraffic($type)
    {
        $typeEnglish  = $type == 'داخل' ? 'in' : 'out';
        $negativeType = $typeEnglish == 'in' ? 'out' : 'in';
        $data         = [
            $typeEnglish             => \DB::raw("`$typeEnglish` + 1"),
            "current_{$typeEnglish}" => \DB::raw("`current_$typeEnglish` + 1"),
        ];

        if ($this->status != "مراجعه نشده") {
            $data["current_{$negativeType}"] = \DB::raw("`current_$negativeType` - 1");
        }

        $model = \App\Models\ReportTraffic::todayRecordOrCreate($this->modirkarevan_id);
        $model->update($data);

        $this->update(['status' => $type]);
        return $this->traffic()->create(compact('type'));
    }

    public function enter()
    {
        $this->newTraffic('داخل');
    }

    public function leave()
    {
        $this->newTraffic('خارج');
    }

    public function addError($message)
    {
        return $this->error()->create(compact('message'));
    }
}
