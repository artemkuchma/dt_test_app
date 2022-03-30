<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         parent::toArray($request);

        return [
            'title' => $this->title,
            'author_name' => $this->author_name,
            'link' => $this->link,
            'date' => $this->created_at,
        ];
    }
}
