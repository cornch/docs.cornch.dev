<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

final class CommentFactory extends Factory
{
    #[ArrayShape([
        'commenter_fingerprint' => 'string',
        'name' => 'string',
        'email' => 'string',
        'delete_password' => 'string',
        'content' => 'string',
        'is_approved' => 'string',
        'reactions_counter' => 'array',
    ])] public function definition(): array
    {
        return [
            'commenter_fingerprint' => $this->faker->sha1,
            'name' => $this->faker->name,
            'delete_password' => '$argon2i$v=19$m=65536,t=4,p=1$ckx4QXRJcS9zU1BtTHk0MA$uHgysftvDsclh6Qjfz5fq0RtJR65zi2XyTmB+HZD5FA',
            'content' => $this->faker->text,
            'is_approved' => $this->faker->boolean(70),
            'reactions_counter' => [
                'thumbs_up' => $this->faker->numberBetween(0, 100),
                'thumbs_down' => $this->faker->numberBetween(0, 100),
                'laugh' => $this->faker->numberBetween(0, 100),
                'hooray' => $this->faker->numberBetween(0, 100),
                'confused' => $this->faker->numberBetween(0, 100),
                'heart' => $this->faker->numberBetween(0, 100),
                'rocket' => $this->faker->numberBetween(0, 100),
                'eyes' => $this->faker->numberBetween(0, 100),
            ],
        ];
    }
}
