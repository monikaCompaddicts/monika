<?php

namespace App\Repositories;

use App\Models\banner;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class bannerRepository
 * @package App\Repositories
 * @version September 11, 2018, 6:36 am UTC
 *
 * @method banner findWithoutFail($id, $columns = ['*'])
 * @method banner find($id, $columns = ['*'])
 * @method banner first($columns = ['*'])
*/
class bannerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'banner_heading',
        'banner_description',
        'banner_image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return banner::class;
    }
}
