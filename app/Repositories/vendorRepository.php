<?php

namespace App\Repositories;

use App\Models\vendor;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class vendorRepository
 * @package App\Repositories
 * @version September 7, 2018, 10:16 am UTC
 *
 * @method vendor findWithoutFail($id, $columns = ['*'])
 * @method vendor find($id, $columns = ['*'])
 * @method vendor first($columns = ['*'])
*/
class vendorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
        'password'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return vendor::class;
    }
}
