<?php

namespace App\Repositories;

use App\Models\test;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class testRepository
 * @package App\Repositories
 * @version September 5, 2018, 8:44 am UTC
 *
 * @method test findWithoutFail($id, $columns = ['*'])
 * @method test find($id, $columns = ['*'])
 * @method test first($columns = ['*'])
*/
class testRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return test::class;
    }
}
