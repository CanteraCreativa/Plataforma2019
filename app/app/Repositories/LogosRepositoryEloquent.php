<?php


namespace App\Repositories;

use App\Models\Logo;
use Prettus\Repository\Eloquent\BaseRepository;

class LogosRepositoryEloquent extends BaseRepository implements LogosRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Logo::class;

    }
}
