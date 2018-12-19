<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdUnits extends Model
{
    protected  $table = 'ad_units';
	protected  $primaryKey = 'id';
	public  $timestamps = false;
}
