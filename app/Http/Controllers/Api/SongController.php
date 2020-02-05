<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\ErrorResponse;
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
     * Get song by id.
     *
     * @param $id
     *
     * @return ErrorResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($id)
    {

        $song = $this->songService->findOrFail($id);
        $user = $this->userService->findOrFail($song->user_id);

        if (is_null($song->path)) {
            return new ErrorResponse('No song uploaded');
        }
        $destination = $this->getSongPath($song, $user);

        return response()->file($destination);
    }

    /**
     * Store function.
     *
     * @param StoreSongRequest $request
     * @param $id
     *
     * @return ErrorResponse
     */
    public function store(StoreSongRequest $request, $id)
    {
        $file = $request->file('song');

        if (is_null($file)){
            return new ErrorResponse('No song uploaded');
        }

        $user = $this->userService->findOrFail($id);

        $song = $file->getClientOriginalName();
        $file->move('songs/' . $user->id, $song);

        $this->songService->create([
            'user_id' => $id,
            'title'   => $request->get('title'),
            'path'    => $song,
        ]);
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
        return public_path() . '/songs/' . $user->id . '/' . $song->path;
    }
}
