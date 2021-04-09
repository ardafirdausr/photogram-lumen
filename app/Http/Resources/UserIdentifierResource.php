<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserIdentifierResource extends Resource {

    public function toArray($request){
        return[
            'id' => $this->when($this->id, (string)$this->id),
            'type' => 'users',
            'links' => [
                'self' => route('getUser', ['id' => $this->id])
            ],
        ];
    }
}

