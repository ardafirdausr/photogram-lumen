<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->when($this->id, (string)$this->id),
            'type' => 'users',
            'name' => $this->when($this->name, $this->name),
            'username' => $this->when($this->username, $this->username),
            'email' => $this->when($this->email, $this->email),
            'avatar' => $this->when($this->avatar, $this->avatar),
            'links' => [
                'self' => route('getUser', ['id' => $this->id]),
            ],
        ];
    }

    public function with($request){
        //add top level data
        return [];
    }
}