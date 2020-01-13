<?php

namespace App\Http\Controllers\Api\Songs;

use App\Services\UserService;
use App\Song;
use Illuminate\Http\Request;
use App\Services\SongService;
use App\Http\Controllers\Controller;

class SongController extends Controller
{
    /**
     * Song service instance.
     *
     * @var SongService
     */
    protected $songService;

    /**User Service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * SongController constructor.
     *
     * @param SongService $songService
     * @param UserService $userService
     *
     * return void
     */
    public function __construct(SongService $songService, UserService $userService)
    {
        $this->songService = $songService;
        $this->userService = $userService;
    }

    /**
     * Store function.
     *
     * @param Request $request
     * @param $id
     */
    public function store(Request $request, $id)
    {
        if($file = $request->file('song')){

            $user = $this->userService->findOrFail($id);

            $song = $file->getClientOriginalName();
            $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
            $file->move('songs/' . $user_folder, $song);

            $this->songService->create([
                'user_id' => $id,
                'name'    => $request->get('title'),
                'path'    => $song,
            ]);
        }
    }

    /**
     * Get song by id.
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function songById($id)
    {
        $song = $this->songService->findOrFail($id);
        $user = $this->userService->findOrFail($id);

        if (!empty($song->path)) {
            $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
            $destination = public_path() . '/songs/' . $user_folder . '/' . $song->path;
            return response()->file($destination);
        }

        return response()->json(['song' => null]);
    }

    /**
     * Get song by id.
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function songsByUserId($id)
    {
        $user  = $this->userService->findOrFail($id);
        $songs = Song::where('user_id', $id)->get();

        if (!empty($songs)) {
            return response()->json($songs);
        }

        return response()->json(['song' => null]);
    }
}
