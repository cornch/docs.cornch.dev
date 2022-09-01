<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

final class CommentReactionFactory extends Factory
{
    #[ArrayShape([
        'reactor_fingerprint' => 'string',
        'reaction' => 'mixed',
    ])]
    public function definition(): array
    {
        return [
            'reactor_fingerprint' => $this->faker->sha1,
            'reaction' => $this->faker->randomElement(['thumbs_up', 'thumbs_down', 'laugh', 'hooray', 'confused', 'heart', 'rocket', 'eyes']),
        ];
    }
}
