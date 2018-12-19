<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdEnquiry extends Model
{
    protected  $table = 'ad_enquiry';
	protected  $primaryKey = 'id';
	public  $timestamps = false;

	public function ad()
    {
        return $this->belongsTo('App\Models\Ads');
    }
}
