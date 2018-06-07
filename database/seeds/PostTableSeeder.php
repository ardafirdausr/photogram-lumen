<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::get()->each(function ($u){            
            for($i = 1; $i <= rand(2, 4); $i++){
                // insert post each User             
                $u->hasPost()->save(factory(App\Models\Post::class, 'createPost')->make());
                // insert profile total_post 
                $u->hasProfile()->increment('total_post');                
                // craete                 
            }            
        }); 

    }
}
