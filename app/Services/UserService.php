<?php

namespace App\Services;

use App\User;
use Intervention\Image\Facades\Image;
use App\Http\Responses\ErrorResponse;

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

    /**
     * Update user details.
     *
     * @param $user
     * @param $request
     *
     * @return void
     */
    public function updateUserDetails($user, $request)
    {
        $user->first_name  = $request->first_name;
        $user->last_name   = $request->last_name;
        $user->description = $request->description;

        $user->save();
    }

    /**
     * Update user image function.
     *
     * @param $user
     * @param $request
     *
     * @return ErrorResponse
     */
    public function updateUserImage($user, $request)
    {
        if ($request->hasFile('image') === false) {
            return new ErrorResponse('There is no image');
        }

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
        
        $name = $user->id . '_' . time() . '.' . $extension;
        $image->save(public_path() . '/images/users/' . $name);

        $user->image = $name;

        $user->save();
    }
}
