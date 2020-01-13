<?php


namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

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
     * The user index response.
     *
     * @return UserResource
     */
    public function index()
    {
        return new UserResource(auth()->user());
    }

    /**
     * Get user profile picture.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function image(Request $request)
    {
        if (!empty($request->user()->image)) {
            $destination = public_path() . '/images/users/' . $request->user()->image;

            return response()->file($destination);
        }

        return response()->json(['image' => null]);
    }

    /**
     * Store user data or image.
     *
     * @param StoreUserRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        if ($request->hasFile('image')) {
            $this->userService->updateUserImage($user, $request);

            return response()->json(['image' => 'success']);
        }

        return response()->json(['image' => null]);
    }

    /**
     * Update User.
     *
     * @param UpdateUserRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        $this->userService->updateUserDetails($user, $request);

        return response()->json(['image' => 'success']);
    }
}
