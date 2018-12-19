<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class advertisement
 * @package App\Models
 * @version December 17, 2018, 12:24 pm IST
 *
 * @property string dimension
 * @property string url
 * @property string start_date
 * @property string end_date
 * @property string client
 */
class advertisement extends Model
{
    use SoftDeletes;

    public $table = 'advertisements';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'image',
        'dimension',
        'url',
        'start_date',
        'end_date',
        'client'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image'  => 'string',
        'dimension' => 'string',
        'url' => 'string',
        'start_date' => 'string',
        'end_date' => 'string',
        'client' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
        'dimension' => 'required',
        'url' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'client' => 'required'
    ];

    
}
