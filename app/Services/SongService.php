<?php

namespace App\Services;

use App\Song;

class SongService extends BaseService
{
    /**
     * Song service repository instance.
     *
     * @var Song
     */
    protected $repository;

    /**
     * AddressService constructor.
     *
     * @param Song $song
     *
     * return void
     */
    public function __construct(Song $song)
    {
        $this->repository = $song;
    }
}
