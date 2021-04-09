<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LikeResource extends Resource {

    public function toArray($request){

        return [
            'id' => $this->id,
            'type' => 'like',
            'relationships' => [
                'user' => new UserIdentifierResource($this->user),
                'post' => $this->when(
                    $this->likeable_type === 'App\Models\Post',
                    new PostIdentifierResource($this->post)
                ),
                'comment' => $this->when(
                    $this->likeable_type === 'App\Models\comment',
                    new CommentResource($this->post)
                ),
            ],
            'included' => [
                'user' => $this->whenLoaded('user')
            ]
        ];
    }

}