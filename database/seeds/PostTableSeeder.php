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
        App\Models\User::all()->each(function ($u){
            // insert post each User        
            // save() use to save/insert new Instance Model     
            // make() generate collection
            // craete() creating instance                        
            // $post = factory(App\Models\Post::class, 'createPost')->make();
            // $u->posts()->save($post);                
            $u->posts()->saveMany(factory(App\Models\Post::class, 'createPost', 3)->make());            
        }); 

    }
}
