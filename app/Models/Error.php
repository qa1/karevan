<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
	protected $guarded = [];
	
	/*
	|--------------------------------------------------------------------------
	| Relations
	|--------------------------------------------------------------------------
	|
	*/

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}
}
