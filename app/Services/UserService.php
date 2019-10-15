<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserService extends Controller
{
    /**
     * The user model.
     *
     * @var User
     */
    protected $repository;

    /**
     * UserService constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->repository = $user;
    }

    public function findOrFail($id)
    {
        return $this->repository->findOrFail($id);
    }
}
