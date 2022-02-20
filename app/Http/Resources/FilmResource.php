<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'episodeId' => $this->episode_id,
            'openingCrawl' => $this->opening_crawl,
            'director' => $this->director,
            'producer' => $this->producer,
            'releaseDate' => $this->release_date,
            'created' => $this->created,
            'edited' => $this->edited
        ];
    }
}
