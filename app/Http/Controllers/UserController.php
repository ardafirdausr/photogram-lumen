<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function auth(Request $request){
        $validator = Validator::make($request->input(), [
            'email' => 'required|string|regex:/^\w+([\.-_]?\w+)*@\w+([\.-_]?\w+)*(\.\w{2,3})+$/',
            'password' => 'required|string|min:6|max:20|regex:/^\w*\d+\w*$/',
        ]);
        if($validator->fails()){
            // return response with helper
            return response()->json([
                'error' => [
                    'message' => 'invalid data',
                    'field' => $validator->errors()
                ]
            ], 400);
        }
        else if($validator->passes()){
            [
                'email' => $email,
                'password' => $password
            ] = $request->input();
            $user = User::where('email', $email)->first();
            if($user && $password === Crypt::decrypt($user->password)){
                [
                    'id' => $id,
                    'username' => $username
                ] = $user;
                $token = JWT::encode(compact('id', 'username'), env('APP_KEY'));
                return (new UserResource($user))->additional([
                    'meta' => compact('token')
                ]);
            }
            return response()->json([
                'error' => ['message' => 'Incorrect email or password']
            ], 400);
        }
        else return response()->json([
            'error' => ['message' => 'Server Error']
        ], 500);
    }

    public function createUser(Request $request){
        // lumen controller contains validate
        // $this->validate($request, [
        //     'email' => 'required|string|unique:users|regex:/^\w+([\.-_]?\w+)*@\w+([\.-_]?\w+)*(\.\w{2,3})+$/',
        //     'password' => 'required|string|confirmed|min:6|max:20|regex:/^\w*\d+\w*$/',
        //     'password_confirmation' => 'required|string|min:6|max:20|regex:/^\w*\d+\w*$/'
        // ]);
        // validator
        $validator = Validator::make($request->input(), [
            'email' => 'required|string|unique:users|regex:/^\w+([\.-_]?\w+)*@\w+([\.-_]?\w+)*(\.\w{2,3})+$/',
            'password' => 'required|string|confirmed|min:6|max:20|regex:/^\w*\d+\w*$/',
            'password_confirmation' => 'required|string|min:6|max:20|regex:/^\w*\d+\w*$/'
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'message' => 'Invalid data',
                    'field' => $validator->errors('error')
                ]], 400);
        }
        else if($validator->passes()){
            $randomUser = explode('@', $request->input('email'))[0].rand(2, 100);
            $query = User::create([
                'email' => $request->input('email'),
                'password' => Crypt::encrypt($request->input('password')),
                'username' => $randomUser,
                'name' => $randomUser
            ]);
            if($query){
                $token = JWT::encode(compact('id', 'username'), env('APP_KEY', 'arda'));
                return (new UserResource(User::find($query->id)))
                        ->additional(['meta' => compact('token')])
                        ->response()
                        ->setStatusCode(201);
            }
            else return response()->json([
                'error' => ['message' => 'Invalid Input Format']
            ], 400);
        }
        else return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ], 500);
    }

    public function getUsers(Request $request){
        $input = $request->input();
        $users = User::select('id', 'username', 'name', 'email', 'avatar')
                     ->orderBy('id', 'asc')
                     ->paginate($input['size'] ?? 10);
        if($users){
            return UserResource::collection($users);
        }
        return response()->json([
            'error' => ['message' => 'Internal Server Error']
        ], 500);
    }

    public function getUser($id){
        try{
            $user = User::find($id);
            if($user){
                return new UserResource($user);
            }
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

    public function getUserProfile(Request $request, $id){
        $user = User::find($id);
        try{
            if($user){
                return new UserResource($user);
            }
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

    public function getUserPosts(Request $request, $id){
        try{
            $input = $request->input();
            $userPosts = User::find($id)
                         ->posts()
                         ->withCount(['likes', 'comments'])
                         ->paginate($input['size'] ?? 12);
            // return $userPosts;
            return PostResource::collection($userPosts);
        }
        catch(QueryException $e){
            return response()->json(
                ['error' => ['message' => 'Internal Server Error']], 401
            );
        }
        return response()->json(
            ['error' => ['message' => 'Internal Server Error']], 500
        );
    }

}
