<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use Factory with global function factory        
        factory(App\Models\User::class, 'createUser', 10)->create();                  
    }
}
