<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    public $fillable = [
        'user_id',
        'user_type',
        'review'
    ];
}
