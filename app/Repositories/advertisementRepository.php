<?php

namespace App\Repositories;

use App\Models\advertisement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class advertisementRepository
 * @package App\Repositories
 * @version December 17, 2018, 12:24 pm IST
 *
 * @method advertisement findWithoutFail($id, $columns = ['*'])
 * @method advertisement find($id, $columns = ['*'])
 * @method advertisement first($columns = ['*'])
*/
class advertisementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dimension',
        'url',
        'start_date',
        'end_date',
        'client'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return advertisement::class;
    }
}
