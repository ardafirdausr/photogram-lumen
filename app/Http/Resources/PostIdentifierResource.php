<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostIdentifierResource extends Resource {

    public function toArray($request){
        return [
            'id' => $this->when($this->id, (string)$this->id),
            'type' => 'posts',
            'links' => [
                'self' => route('getPost', ['id' => $this->id])
            ]
        ];
    }
}