<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Post;

class PostController extends Controller{

    public function getAllPost(){
        return response()->json(['data' => Post::get()]);
    }

}