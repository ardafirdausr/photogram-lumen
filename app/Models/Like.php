<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model{

    protected $table = "likes";
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    public function likedByUser(){
        return $this->belongsTo(User::class, 'id');
    }

    public function a(){ 
        return $this->morphTo();
    }

}