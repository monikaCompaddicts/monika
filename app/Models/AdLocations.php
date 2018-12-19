<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdLocations extends Model
{
    protected  $table = 'ad_locations';
	protected  $primaryKey = 'id';
	public  $timestamps = false;

	public function ad_loctaion()
    {
        return $this->belongsTo('App\Models\Ads');
    }
    
    public function loc_loctaion()
    {
        return $this->belongsTo('App\Models\location');
    }
}
