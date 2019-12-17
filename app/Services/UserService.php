<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

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

    /**
     * Save function.
     *
     * @return bool
     */
    public function save()
    {
        return  $this->repository->save();
    }

    /**
     * Create function.
     *
     * @param $array
     *
     * @return mixed
     */
    public function create($array)
    {
        return  $this->repository->create($array);
    }

    /**
     * Get full name.
     *
     * @param Request $request
     *
     * @return string
     */
    public function fullName(Request $request)
    {
        return $request->user()->first_name . ' ' . $request->user()->last_name;
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
