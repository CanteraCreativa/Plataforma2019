<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InterestRepository;
use App\Models\Interest;

/**
 * Class InterestRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InterestRepositoryEloquent extends BaseRepository implements InterestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Interest::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
