<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'avatar'];

    //one to one user-profile
    public function hasProfile(){
        return $this->hasOne(Profile::class, 'user_id');
    }

    //one to many user-post
    public function hasPost(){
        return $this->hasMany(Post::class, 'user_id');
    }

    public function hasComment(){
        return $this->belongsToMany(Post::class, 'comments', 'user_id') //declare MtM and its table name
                    ->withPivot('comment') //declare accessible column in pivot 
                    ->using(Comment::class) //actualy this is using for modeling pivot    
                    ->as('comment') //how to call pivot table rather than call "pivot"
                    ->withTimestamps(); //created and updated at
    }

    public function hasLike(){
        return $this->hasMany(Like::class, 'user_id');
    }

    public function hasFollow(){
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');                    
    }

    public function followedBy(){
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }
    
}