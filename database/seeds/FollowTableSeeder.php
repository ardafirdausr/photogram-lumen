<?php

use Illuminate\Database\Seeder;

class FollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::get()->each(function($u){
            for($i = 0; $i <= rand(4, 9); $i++ ){
                $followedUser = App\Models\User::inRandomOrder()->first()->id;
                if($followedUser !== $u->id){
                    $follow = $u->follows()->toggle([$followedUser]);                                            
                }
            }
        });
    }
}
