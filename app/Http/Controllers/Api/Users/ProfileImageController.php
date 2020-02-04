<?php

namespace App\Http\Controllers\Api\Users;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request, $id)
    {
        $user = $this->userService->findOrFail($id);

        if ($request->hasFile('image')) {
            $this->updateUserImage($user, $request);

            return response()->json(['image' => 'success']);
        }

        return response()->json(['image' => null]);
    }

    /**
     * Get user profile picture.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($id)
    {
        $user = $this->userService->findOrFail($id);

        if (is_null($user->image)) {
            return response()->json(['image' => null]);
        }

        $destination = public_path() . '/images/users/' . $user->image;

        return response()->file($destination);
    }

    /**
     * Update user image function.
     *
     * @param $user
     * @param $request
     *
     * @return void
     */
    public function updateUserImage($user, $request)
    {
        if ($request->hasFile('image')) {
            $image = Image::make($request->file('image'));

            if (!empty($user->image)) {
                $currentImage = public_path() . '/images/users/' . $user->image;
                if (file_exists($currentImage)) {
                    unlink($currentImage);
                }
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $image->crop(
                ceil($request->width),
                ceil($request->height),
                ceil($request->left),
                ceil($request->top)
            );
            $name = auth()->user()->first_name . '_' . auth()->user()->last_name . '_' . time() . '.' . $extension;
            $image->save(public_path() . '/images/users/' . $name);

            $user->image = $name;

            $user->save();
        }
    }
}
