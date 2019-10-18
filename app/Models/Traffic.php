<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    protected $table   = "traffics";
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
     */
    public function user()
    {
    	return $this->belongsTo(\App\Models\User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Validations
    |--------------------------------------------------------------------------
     */
    public function isIn()
    {
        return $this->type == "داخل";
    }
}
