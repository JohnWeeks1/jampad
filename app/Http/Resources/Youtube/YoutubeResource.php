<?php

namespace App\Http\Resources\Youtube;

use Illuminate\Http\Resources\Json\JsonResource;

class YoutubeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'   => $this->title,
            'url'     => $this->url,
        ];
    }
}
