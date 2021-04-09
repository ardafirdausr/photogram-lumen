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
            for($i = 0; $i <= rand(4,5); $i++){
                // attach comment to pivot table
                $u->comments()->attach(
                    App\Models\Post::inRandomOrder()->first()->id,
                    ['comment' => factory( App\Models\Comment::class, 'createComment')->make()->comment]
                );
            }
        });
    }
}
