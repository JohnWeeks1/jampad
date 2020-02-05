<?php

namespace App\Http\Controllers\Api;

use App\Services\FollowingService;
use App\Http\Controllers\Controller;

class FollowingController extends Controller
{
    /**
     * Following service instance.
     *
     * @var FollowingService
     */
    protected $followingService;

    /**
     * FollowingController constructor.
     *
     * @param FollowingService $followingService
     */
    public function __construct(FollowingService $followingService)
    {
        $this->followingService = $followingService;
    }

    /**
     * Show users following logged in user.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $following = $this->followingService->where([['user_id', $id]])->get();

        $users = $following->map(function($event) {
            return $event->users;
        });

        return response()->json($users);
    }
}
