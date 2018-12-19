<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Ticker extends Model
{
    protected  $table = 'ticker';
	protected  $primaryKey = 'id';
	public  $timestamps = false;
}
