<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SubmissionRepository.
 *
 * @package namespace App\Repositories;
 */
interface SubmissionRepository extends RepositoryInterface
{
    public function fromUser(\App\User $user);
}
