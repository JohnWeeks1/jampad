<?php

namespace App\Http\Controllers\Api\User;

use App\Services\SongService;
use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\Song\SongsByUserIdResource;

class SongsController extends Controller
{
    /**
     * Song service instance.
     *
     * @var SongService
     */
    protected $songService;

    /**
     * SongController constructor.
     *
     * @param SongService $songService
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * Get song by user id.
     *
     * @param $id
     *
     * @return SongsByUserIdResource|ErrorResponse
     */
    public function show($id)
    {
        $songs = $this->songService->where([['user_id', $id]])->get();

        if (is_null($songs)) {
            return new ErrorResponse('No songs');
        }

        return new SongsByUserIdResource(collect($songs));
    }
}
