<?php

namespace App\Repositories;

use App\Models\location;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class locationRepository
 * @package App\Repositories
 * @version September 10, 2018, 9:19 am UTC
 *
 * @method location findWithoutFail($id, $columns = ['*'])
 * @method location find($id, $columns = ['*'])
 * @method location first($columns = ['*'])
*/
class locationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'market_name',
        'address'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return location::class;
    }
}
