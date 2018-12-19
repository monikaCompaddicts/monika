<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class location
 * @package App\Models
 * @version September 10, 2018, 9:19 am UTC
 *
 * @property string market_name
 * @property string address
 */
class location extends Model
{
    use SoftDeletes;

    public $table = 'locations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'market_name',
        'address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'market_name' => 'string',
        'address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'market_name' => 'required',
        'address' => 'required'
    ];
    
    public function ad_loctaion()
    {
        return $this->hasMany('App\Models\AdLocations', 'location');
    }
    
}
