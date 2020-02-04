<?php

namespace App\Services;

use App\User;

class UserService extends BaseService
{
    /**
     * UserService repository instance.
     *
     * @var User
     */
    protected $repository;

    /**
     * UserService constructor.
     *
     * @param User $user
     *
     * return void
     */
    public function __construct(User $user)
    {
        $this->repository = $user;
    }
}
