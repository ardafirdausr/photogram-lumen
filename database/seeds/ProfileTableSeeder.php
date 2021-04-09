<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::get()->each(function($u){
            // insert profile each User
            $u->profile()->save(factory(App\Models\Profile::class, 'createBio')->make());            
        });

    }
}
