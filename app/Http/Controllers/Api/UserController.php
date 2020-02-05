<?php


namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Users\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * User service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * SongController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * The user index response.
     *
     * @return UserResource
     */
    public function index()
    {
        return new UserResource(auth()->user());
    }

    /**
     * Update user.
     *
     * @param UpdateUserRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse#
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        $this->userService->updateUserDetails($user, $request);

        return response()->json(['image' => 'success']);
    }
}
