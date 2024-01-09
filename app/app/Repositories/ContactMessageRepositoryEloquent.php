<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContactMessageRepository;
use App\Models\ContactMessage;

/**
 * Class ContactMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContactMessageRepositoryEloquent extends BaseRepository implements ContactMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactMessage::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
