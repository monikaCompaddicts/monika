<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class settings
 * @package App\Models
 * @version September 11, 2018, 5:02 am UTC
 *
 * @property string banner_heading
 * @property string banner_description
 * @property string banner_image
 * @property string ad-banner
 */
class settings extends Model
{
    use SoftDeletes;

    public $table = 'settings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'banner_heading',
        'banner_description',
        'banner_image',
        'ad_banner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'banner_heading' => 'string',
        'banner_description' => 'string',
        'banner_image' => 'string',
        'ad_banner' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'banner_heading' => 'required',
        'banner_description' => 'required',
        //'banner_image' => 'required',
       // 'ad_banner' => 'required'
    ];

    
}
