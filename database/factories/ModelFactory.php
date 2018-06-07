<?php

// import Crypt 
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->defineAs(App\Models\User::class, 'createUser',function (Faker\Generator $faker) {
    return [
        'username' => $faker->username,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl($width = 640 , $height = 480, 'cats'),
        'password' => Crypt::encrypt($faker->password),
    ];
});

$factory->defineAs(App\Models\Post::class, 'createPost', function(Faker\Generator $faker){
    return [
        'image' => $faker->imageUrl($width = 800, $height = 800),
        'caption' => $faker->realText($maxNbChars = 40),
        'latitude' => $faker->latitude($min = -8, $max = 5),
        'longitude' => $faker->longitude($min = 95, $max = 140)
    ];
});

$factory->defineAs(App\Models\Profile::class, 'createBio', function(Faker\Generator $faker){
    return [
        'bio' => $faker->realText($maxNbChars = 100),
    ];
});

$factory->defineAs(App\Models\Comment::class, 'createComment', function(Faker\Generator $faker){
    return [
        'comment' => $faker->realText($maxNbChars = 30)
    ];
});
