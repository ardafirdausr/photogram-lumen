<?php

use Illuminate\Database\Seeder;

class LikeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Post::get()->each(function($p){
            for($i = 1; $i <= rand(4, 5); $i++){
                $randomUser = App\Models\User::inRandomOrder()->first()->id;          
                // write in polymorphism table      
                $p->likes()->firstOrCreate([
                    'user_id' => $randomUser,
                ]);                
            }
        });        
    }
}
