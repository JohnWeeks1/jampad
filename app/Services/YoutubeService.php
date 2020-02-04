<?php

namespace App\Services;

use App\Youtube;

class YoutubeService extends BaseService
{
    /**
     * YoutubeService repository instance.
     *
     * @var Youtube
     */
    protected $repository;

    /**
     * YoutubeService constructor.
     *
     * @param Youtube $youtube
     *
     * return void
     */
    public function __construct(Youtube $youtube)
    {
        $this->repository = $youtube;
    }
}
