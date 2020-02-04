<?php

namespace App\Services;

use App\Following;

class FollowingService extends BaseService
{
    /**
     * FollowingService repository instance.
     *
     * @var Following
     */
    protected $repository;

    /**
     * FollowingService constructor.
     *
     * @param Following $following
     *
     * return void
     */
    public function __construct(Following $following)
    {
        $this->repository = $following;
    }
}
