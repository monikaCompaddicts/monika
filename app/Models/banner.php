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
        'logo',
        'loader',
        'email',
        'mobile',
        'fb_page_link',
        'twitter_page_link',
        'google_page_lnik',
        'instragram_page_link',
        'android_play_store_link',
        'ios_app_store_link',

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
        'logo'                    => 'string',
        'loader'                  => 'string',
        'email'                   => 'string',
        'mobile'                  => 'string',
        'fb_page_link'            => 'string',
        'twitter_page_link'       => 'string',
        'google_page_lnik'        => 'string',
        'instragram_page_link'    => 'string',
        'android_play_store_link' => 'string',
        'ios_app_store_link'      => 'string',
        'banner_heading'          => 'string',
        'banner_description'      => 'string',
        'banner_image'            => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'banner_heading' => 'required',
        //'banner_description' => 'required',
        //'banner_image'      => 'required'
    ];

    
}
