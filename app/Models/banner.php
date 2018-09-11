<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class banner
 * @package App\Models
 * @version September 11, 2018, 6:36 am UTC
 *
 * @property string banner_heading
 * @property string banner_description
 * @property string banner_image
 */
class banner extends Model
{
    use SoftDeletes;

    public $table = 'banners';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'banner_heading',
        'banner_description',
        'banner_image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'banner_heading' => 'string',
        'banner_description' => 'string',
        'banner_image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'banner_heading' => 'required',
        'banner_description' => 'required'
    ];

    
}
