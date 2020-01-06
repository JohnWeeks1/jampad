<?php

namespace App\Services;

use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SongService extends Controller
{
    /**
     * The song model.
     *
     * @var Song
     */
    protected $repository;

    /**
     * UserService constructor.
     *
     * @param Song $song
     */
    public function __construct(Song $song)
    {
        $this->repository = $song;
    }

    /**
     * Find song by id.
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
}
