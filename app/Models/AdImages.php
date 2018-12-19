<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImages extends Model
{
    protected  $table = 'ad_images';
	protected  $primaryKey = 'id';
	public  $timestamps = false;

	public function ad()
    {
        return $this->belongsTo('App\Models\Ads');
    }
}
