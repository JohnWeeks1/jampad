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

    /**
     * Store user data or image.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        if($request->file('image')) {
            $this->userService->updateUserImage($user, $request);

            return response()->json([
                'user_image' => 'OK'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        $this->userService->updateUserDetails($user, $request);
    }
}
