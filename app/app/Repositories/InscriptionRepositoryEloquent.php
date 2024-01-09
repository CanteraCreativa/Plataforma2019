<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InscriptionRepository;
use App\Models\Inscription;

/**
 * Class InscriptionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InscriptionRepositoryEloquent extends BaseRepository implements InscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Inscription::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
