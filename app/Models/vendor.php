<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class vendor
 * @package App\Models
 * @version September 7, 2018, 10:16 am UTC
 *
 * @property string name
 * @property string email
 * @property string phone
 * @property string password
 */
class vendor extends Model
{
    use SoftDeletes;

    public $table = 'vendors';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'required'
    ];

    
}
