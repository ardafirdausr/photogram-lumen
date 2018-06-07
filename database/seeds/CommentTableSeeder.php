<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::get()->each(function($u){
            // insert comment to random post 
            for($i = 0; $i < rand(2,3); $i++){
                // attach comment to pivot table
                $u->hasComment()->attach(
                    App\Models\Post::inRandomOrder()->first()->id,
                    ['comment' => factory( App\Models\Comment::class, 'createComment')->make()->comment] 
                );       
                $u->hasPost()->increment('comment');         
                // $u->hasComment->comment->addComment(
                    // App\Models\Post::inRandomOrder()->first()->id,
                    // factory(
                        // App\Models\Comment::class, 
                        // 'createComment'
                    // )->make(),
                    // $u->id
                // );
            }
        });
    }
}
