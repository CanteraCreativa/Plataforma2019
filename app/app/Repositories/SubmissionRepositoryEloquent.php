<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SubmissionRepository;
use App\Models\Submission;

/**
 * Class SubmissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubmissionRepositoryEloquent extends BaseRepository implements SubmissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Submission::class;
    }

    protected $fieldSearchable = [
        'state',
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function fromUser(\App\User $user)
    {
        $inscriptions = $user->account->creativeData->inscriptions()->modelKeys();

        return $this->findWhereIn('inscription_id', $inscriptions);
    }
}
