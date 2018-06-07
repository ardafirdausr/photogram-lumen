<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Comment extends Pivot{
    
    protected $table = "comments";

    // /*
    public function addComment($post_id, $comment, $user_id){
        $user = Auth::user() ?? App\Models\User::find($user_id);
        $user->hasComment()->attach([$post_id], [
            "comment" => $comment
        ]); 
    }
    // */

}