<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Http\Requests\Users\StoreUserRequest;

class ProfileImageController extends Controller
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
     * Store function.
     *
     * @param StoreUserRequest $request
     * @param $id
     *
     * @return ErrorResponse|SuccessResponse
     */
    public function store(StoreUserRequest $request, $id)
    {
        if ($request->hasFile('image') === false) {
            return new ErrorResponse('The image did not store');
        }

        $user = $this->userService->findOrFail($id);
        $this->userService->updateUserImage($user, $request);

        return new SuccessResponse('The image has been saved');
    }

    /**
     * Get user profile picture.
     *
     * @param $id
     *
     * @return ErrorResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($id)
    {
        $user = $this->userService->findOrFail($id);

        if (is_null($user->image)) {
            return new ErrorResponse('There is no image');
        }

        $destination = public_path() . '/images/users/' . $user->image;

        return response()->file($destination);
    }
}
