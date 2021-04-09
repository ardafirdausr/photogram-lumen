<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentResource extends Resource {

    public function toArray($request){
        return [
            'id' => (string)$this->id,
            'type' => 'comment',
            'comment' => $this->comment,
            'created_at' => $this->created_at->toDateString(),
            'relationships' => [
                'user' => new UserIdentifierResource($this->user),
                'post' => new PostIdentifierResource($this->post)
                // 'post' => [
                //     'id' => $this->comment->post_id,
                //     'type' => 'posts',
                //     'links' => ['self' => route('getPostComments', ['id' => $this->comment->post_id])]
                // ]
            ],
            'included' => [
                'user' => $this->whenLoaded('user')
            ]
        ];
    }

}