<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model{

    protected $table = "likes";
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    // user can have many like
    public function user(){
        //belongs -> local, foreign
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // like of post
    public function post(){
        if($this->likeable_type === 'App\Models\Post')
        return $this->belongsTo(Post::class, 'likeable_id', 'id');
    }

    //like of comment
    public function comment(){
        if($this->likeable_type === 'App\Models\Comment')
        return $this->belongsTo(Comment::class, 'likeable_id', 'id');
    }

    public function likeable(){
        return $this->morphTo();
    }

}