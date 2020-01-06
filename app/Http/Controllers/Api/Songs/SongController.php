<?php

namespace App\Http\Controllers\Api\Songs;

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

    /**
     * SongController constructor.
     *
     * @param SongService $songService
     *
     * return void
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
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

        if (!empty($song->path)) {
            $destination = public_path() . '/' . $song->path;
            return response()->file($destination);
        }

        return response()->json(['song' => null]);
    }
}
