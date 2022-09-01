<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class CommentReactionsCounter implements Castable, JsonSerializable, Jsonable
{
    public const COLLAPSE_THRESHOLD = 3;

    public readonly bool $allActivated;

    public readonly bool $shouldBeCollapsed;

    public readonly array $topEmojis;

    public readonly int $total;

    public function __construct(
        public readonly int $thumbsUp = 0,
        public readonly int $thumbsDown = 0,
        public readonly int $laugh = 0,
        public readonly int $hooray = 0,
        public readonly int $confused = 0,
        public readonly int $heart = 0,
        public readonly int $rocket = 0,
        public readonly int $eyes = 0,
    ) {
        $counts = [$thumbsUp, $thumbsDown, $laugh, $hooray, $confused, $heart, $rocket, $eyes];
        $filteredCounts = array_filter($counts);
        $filteredCountsLength = count($filteredCounts);

        $this->allActivated = $filteredCountsLength !== count($counts);
        $this->shouldBeCollapsed = $filteredCountsLength >= self::COLLAPSE_THRESHOLD;
        $this->topEmojis = $this->getTopEmojis();
        $this->total = array_sum($counts);
    }

    public static function fromArray(array $value): self
    {
        return new static(
            thumbsUp: $value['thumbs_up'] ?? 0,
            thumbsDown: $value['thumbs_down'] ?? 0,
            laugh: $value['laugh'] ?? 0,
            hooray: $value['hooray'] ?? 0,
            confused: $value['confused'] ?? 0,
            heart: $value['heart'] ?? 0,
            rocket: $value['rocket'] ?? 0,
            eyes: $value['eyes'] ?? 0,
        );
    }

    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR));
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class() implements CastsAttributes
        {
            public function get($model, string $key, $value, array $attributes): CommentReactionsCounter
            {
                if (empty($value)) {
                    return new CommentReactionsCounter();
                }

                return CommentReactionsCounter::fromJson($value);
            }

            public function set($model, string $key, $value, array $attributes): array
            {
                throw_unless($value instanceof CommentReactionsCounter || is_array($value), InvalidArgumentException::class, 'The value must be an instance of CommentReactionsCount or an array.');

                if (is_array($value)) {
                    $value = CommentReactionsCounter::fromArray($value);
                }

                return [
                    $key => $value->toJson(),
                ];
            }
        };
    }

    #[ArrayShape([
        'thumbsUp' => 'int',
        'thumbsDown' => 'int',
        'laugh' => 'int',
        'hooray' => 'int',
        'confused' => 'int',
        'heart' => 'int',
        'rocket' => 'int',
        'eyes' => 'int',
    ])]
 public function jsonSerialize(): array
 {
     return [
         'thumbsUp' => $this->thumbsUp,
         'thumbsDown' => $this->thumbsDown,
         'laugh' => $this->laugh,
         'hooray' => $this->hooray,
         'confused' => $this->confused,
         'heart' => $this->heart,
         'rocket' => $this->rocket,
         'eyes' => $this->eyes,
     ];
 }

    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    private function getTopEmojis(): array
    {
        return collect($this->jsonSerialize())
            ->sortDesc()
            ->slice(0, self::COLLAPSE_THRESHOLD)
            ->filter()
            ->map(fn ($_, $k) => ([
                'thumbsUp' => '👍',
                'thumbsDown' => '👎',
                'laugh' => '😆',
                'hooray' => '🎉',
                'confused' => '😕',
                'heart' => '❤️',
                'rocket' => '🚀',
                'eyes' => '👀',
            ])[$k])
            ->toArray();
    }
}
