<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToEnum implements IsCastContract
{
    /**
     * @param  class-string  $enum
     */
    public function __construct(
        public string $enum,
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): mixed
    {
        if (! $input) {
            return $this->default;
        }

        return $this->enum::tryFrom($input) ?? $this->default;
    }
}
