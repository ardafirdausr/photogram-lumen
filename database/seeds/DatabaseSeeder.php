<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // call seeders
        $this->call([
            'UserTableSeeder',
            'ProfileTableSeeder',
            'PostTableSeeder',  
            'CommentTableSeeder',
            'LikeTableSeeder',
            'FollowTableSeeder'
        ]);
    }
}
