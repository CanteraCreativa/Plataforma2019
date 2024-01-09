<?php


namespace App\Repositories;


use App\Models\SiteContent;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class SiteContentRepositoryEloquent extends BaseRepository implements SiteContentRepository
{
    public function model()
    {
        return SiteContent::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
