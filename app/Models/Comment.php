<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// pivot table
class Comment extends Pivot{

    protected $table = "comments";

    //each comment owned by a user
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    //each comment in a post
    public function post(){
        return $this->hasOne(Post::class, 'id', 'post_id');
    }


}