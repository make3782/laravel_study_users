<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function(Faker $faker) {
    $data_time = $faker->date . ' ' . $faker->time;
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'activated' => true,
        'created_at' => $data_time,
        'updated_at' => $data_time,

    ];
});

?>