<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'posts',
            'image' => $this->when($this->image, $this->image),
            'caption' => $this->when($this->caption, $this->caption),
            'latitidue' => $this->when($this->latitude, $this->latitude),
            'longitude' => $this->when($this->longitude, $this->longitude),
            'links' => [
                'self' => route('getPost', ['id' => $this->id])
            ],
            'relationships' => [
                'user' => new UserIdentifierResource($this),
                'comments' => [
                    'comments_count' => $this->comments_count,
                    'links' => [
                        'self' => route('getPostComments', ['id' => $this->id])
                    ]
                ],
                'likes' => [
                    'likes_count' => $this->likes_count,
                    'links' => [
                        'self' => route('getPostLikes', ['id' => $this->id])
                    ]
                ]
            ],
            'included'  => [
                'user' => $this->whenLoaded('user'),
                'comments' => $this->whenLoaded('comments'),
                'likes' => $this->whenLoaded('likes')
            ]
        ];
    }

    public function with($request){
        // add top level data eg meta or link that
        return [];
    }
}