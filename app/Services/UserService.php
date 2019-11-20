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

    /**
     * Find user by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->repository->findOrFail($id);
    }

    public function fullName(Request $request)
    {
        return $request->user()->first_name . ' ' . $request->user()->last_name;
    }
}
