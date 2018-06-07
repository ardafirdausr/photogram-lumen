<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{

    protected $table = "posts";
    protected $fillable = ['image', 'caption', 'latitude', 'longitude'];

    public function ownedBy(){
        return $this->belongsTo(User::class, 'id');
    }

    public function commentedBy(){ // class this to call User table
        return $this->belongsToMany(User::class, 'comments', 'post_id') // M-to-M with pivot table "comments" 
                    ->withPivot('comment') // give access to column content in pivot table
                    ->using(Comment::class) //actualy this is using for modeling pivot
                    ->as('comment') // call "pivot" table with "comment"
                    ->withTimestamps(); // give createAt and updateAt to comment table
    }

    public function likedBy(){
        return $this->morphMany(Like::class, 'likeable'); // 2nd parameter from function in Like
    }

}