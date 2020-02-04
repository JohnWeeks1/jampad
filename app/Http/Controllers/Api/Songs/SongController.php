<?php

namespace App\Http\Controllers\Api\Songs;

use App\Services\UserService;
use App\Services\SongService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Song\SongsResource;
use App\Http\Requests\Songs\StoreSongRequest;
use App\Http\Resources\Song\SongsByUserIdResource;

class SongController extends Controller
{
    /**
     * Song service instance.
     *
     * @var SongService
     */
    protected $songService;

    /**
     * User service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * SongController constructor.
     *
     * @param SongService $songService
     * @param UserService $userService
     */
    public function __construct(SongService $songService, UserService $userService)
    {
        $this->songService = $songService;
        $this->userService = $userService;
    }

    /**
     * All songs.
     *
     * @return SongsResource
     */
    public function index()
    {
        return new SongsResource($this->songService->all());
    }

    /**
     * Store function.
     *
     * @param StoreSongRequest $request
     * @param $id
     *
     * return void
     */
    public function store(StoreSongRequest $request, $id)
    {
        if($file = $request->file('song')){

            $user = $this->userService->findOrFail($id);

            $song = $file->getClientOriginalName();
            $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
            $file->move('songs/' . $user_folder, $song);

            $this->songService->create([
                'user_id' => $id,
                'title'   => $request->get('title'),
                'path'    => $song,
            ]);
        }
    }

    public function destroy($id)
    {
        $song = $this->songService->findOrFail($id);
        $user = $this->userService->findOrFail($song->user_id);

        $destination = $this->getSongPath($song, $user);

        if (file_exists($destination)) {
            unlink($destination);
            $song->delete();
        }
    }

    public function getSongPath($song, $user)
    {
        $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
        return public_path() . '/songs/' . $user_folder . '/' . $song->path;
    }

    /**
     * Get song by id.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function songById($id)
    {

        $song = $this->songService->findOrFail($id);
        $user = $this->userService->findOrFail($song->user_id);

        if (is_null($song->path)) {
            return response()->json(['song' => null]);
        }
        $destination = $this->getSongPath($song, $user);

        return response()->file($destination);
    }

    /**
     * Get song by user id.
     *
     * @param $id
     *
     * @return SongsByUserIdResource|\Illuminate\Http\JsonResponse
     */
    public function songsByUserId($id)
    {
        $songs = $this->songService->where('user_id', $id)->get();

        if (is_null($songs)) {
            return response()->json(['song' => null]);
        }

        return new SongsByUserIdResource(collect($songs));
    }
}
