<?php

use App\User;
use App\Channel;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Thread::class, function($faker){
    return [
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'channel_id' => function(){
            return factory(App\Channel::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->state(App\Thread::class, 'withExistingUsers', function($faker){
    return [
        'user_id' => User::all()->random()->id,
        'channel_id' => Channel::all()->random()->id        
    ];
});

$factory->define(App\Reply::class, function($faker){
    return [
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'thread_id' => function(){
            return factory(App\Thread::class)->create()->id;
        },
        'body' => $faker->paragraph
    ];
});

$factory->define(App\Channel::class, function($faker){
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});

