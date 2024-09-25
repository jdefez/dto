<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToDto implements IsCastContract
{
    /**
     * @param  class-string  $dto
     */
    public function __construct(
        public string $dto,
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): mixed
    {
        if (is_array($input) || is_object($input)) {
            return $this->dto::make($input);
        }

        return $this->default;
    }
}
