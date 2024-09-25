<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToFloat implements IsCastContract
{
    public function __construct(
        public int $precision = 1,
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): ?float
    {
        if (! $input || ! is_numeric($input)) {
            return $this->default;
        }

        if (is_string($input)) {
            $input = (float) $input;
        }

        if ($this->precision) {
            return round($input, $this->precision);
        }

        return $input;
    }
}
