<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class advertisementClients
 * @package App\Models
 * @version December 17, 2018, 12:17 pm IST
 *
 * @property string name
 * @property string email
 * @property string mobile
 */
class advertisementClients extends Model
{
    use SoftDeletes;

    public $table = 'advertisement_clients';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'mobile'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'mobile' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'mobile' => 'required'
    ];

    
}
