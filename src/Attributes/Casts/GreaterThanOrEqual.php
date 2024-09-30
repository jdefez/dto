<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class GreaterThanOrEqual implements IsCastContract
{
    public function __construct(
        public int|float $min,
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): mixed
    {
        if (! $input || ! is_numeric($input)) {
            return $this->default;
        }

        return $input >= $this->min ? $input : $this->default;
    }
}
