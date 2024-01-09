<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GuidelineRepository;
use App\Models\Guideline;

/**
 * Class GuidelineRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GuidelineRepositoryEloquent extends BaseRepository implements GuidelineRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Guideline::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
