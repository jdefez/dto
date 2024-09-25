<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToInt implements IsCastContract
{
    public function __construct(
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
            return (int) $input;
        }

        if (is_float($input)) {
            return (int) $input;
        }

        return $input;
    }
}
