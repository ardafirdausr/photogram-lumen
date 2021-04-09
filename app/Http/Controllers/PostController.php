<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

use App\Http\Resources\PostResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;

class PostController extends Controller{

    public function getPosts(Request $request){
        $input = $request->input();
        $column = ['*'];
        $input['sortBy'] = $input['sortBy'] ?? 'created_at';
        $input['orderBy'] = $input['orderBy'] ?? 'desc';
        if(isset($input['column']) && is_array($input['column'])){
            $column = array_merge(['id', 'user_id'], $input['column']);
        }
        try{
            $posts = Post::select(...$column)
                     ->with('user:id,username,avatar')
                     ->withCount(['likes', 'comments'])
                     ->orderBy($input['sortBy'], $input['orderBy'])
                     ->paginate($input['size'] ?? 5); // serve pagination
            if($posts)
                // return response()->json($posts, 200);
                return PostResource::collection($posts)
                        ->response()
                        ->setStatusCode(200);
        }
        catch(QueryException $e){
            return response()->json([
                'error' => ['message' => 'Failed retrive data']
            ], 400);
        }
        return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ], 500);
    }

    public function getPost(Request $request, $id){
        try{
            $post = Post::with('user:id,username,avatar')
                    ->withCount(['likes', 'comments'])
                    ->find($id);
            return (new PostResource($post))->response()->setStatusCode(200);
        }
        catch(QueryException $e){
            return response()->json([
                'error' => ['message' => 'Failed Retrive Data']
            ], 500);
        }
        return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ], 500);
    }

    public function getPostComments(Request $request, $id){
        $input = $request->input();
        try{
            $userComments = Comment::where('post_id', $id)
                            ->with('user:id,username,avatar')
                            ->paginate($input['size'] ?? 10);
            return CommentResource::collection($userComments)
                    ->response()
                    ->setStatusCode(200);
        }
        catch(QueryException $e){
            return response()->json([
                'error' => ['message' => $e]
            ]);
        }
        return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ]);
    }

    public function getPostLikes(Request $request, $id){
        try{
            $input = $request->input();
            $likes = Like::where('likeable_id', $id)
                     ->with('user:id,username,avatar')
                     ->get();
        return LikeResource::collection($likes)
                ->response()
                ->setStatusCode(200);;
        }
        catch(QueryException $e){
            return response()->json([
                'error' =>  ['message' => 'Failed Retrive Data']
            ], 401);
        }
        return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ], 500);
    }

}