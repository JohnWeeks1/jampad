<?php

namespace App\Http\Controllers\Api\Following;

use App\Following;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowingController extends Controller
{
    public function show($id)
    {
        $following = Following::where('user_id', $id)->get();

        $users = $following->map(function($event) {
            return $event->users;
        });

        return response()->json($users);
    }
}
