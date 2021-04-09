<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{

    protected $table = 'profiles';
    protected $fillable = ['bio'];

    public function user(){
        return $this->belongsTo(User::class, 'id');
    }

}