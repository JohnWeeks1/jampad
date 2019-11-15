<?php


namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * The user service.
     *
     * @var $userService
     */
    protected $userService;

    /**
     * The user controller constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Find user by id.
     *
     * @param Request $request
     *
     * @return UserResource
     */
    public function index(Request $request)
    {
        $user = $this->userService->findOrFail($request->user()->id);

        return New UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        $user->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }
}
