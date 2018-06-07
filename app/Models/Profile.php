<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{

    protected $fillable = ['total_post', 'total_follower', 'total_following', 'bio'];

    public function ownedBy(){
        return $this->belongsTo(User::class, 'id');
    }

}