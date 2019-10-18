<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modirkarevan extends Model
{
	protected $guarded = [];

	public function persons()
	{
		return $this->hasMany(\App\Models\Person::class);
	}
}
