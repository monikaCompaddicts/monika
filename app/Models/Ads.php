<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected  $table = 'ads';
	protected  $primaryKey = 'id';
	public  $timestamps = false;

	public function ad_loctaion()
	{
	    return $this->hasMany('App\Models\AdLocations', 'ad_id');
	}

	public function ad_images()
	{
	    return $this->hasMany('App\Models\AdImages', 'ad_id');
	}

	public function ad_enquiry()
	{
	    return $this->hasMany('App\Models\AdEnquiry', 'ad_id');
	}
}
