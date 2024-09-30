<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class LessThanOrEqual implements IsCastContract
{
    public function __construct(
        public int|float $max,
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

        return $input <= $this->max ? $input : $this->default;
    }
}
