<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = [];
	
    /**
     * Relation
     */
    public function person()
    {
        return $this->belongsTo(\App\Models\Person::class);
    }

    /**
     * Helpers
     */
    public function isRead()
    {
    	return $this->status == "خوانده شده";
    }
}
