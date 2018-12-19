<?php

namespace App\Repositories;

use App\Models\advertisementClients;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class advertisementClientsRepository
 * @package App\Repositories
 * @version December 17, 2018, 12:17 pm IST
 *
 * @method advertisementClients findWithoutFail($id, $columns = ['*'])
 * @method advertisementClients find($id, $columns = ['*'])
 * @method advertisementClients first($columns = ['*'])
*/
class advertisementClientsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'mobile'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return advertisementClients::class;
    }
}
