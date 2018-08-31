<?php

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' => $faker->randomDigit,
        'message' => $faker->text(),
        'parent_id' => $faker->randomDigit,
    ];
});
