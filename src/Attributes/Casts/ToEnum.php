<?php

namespace Ayctor\Dto\Attributes\Casts;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;

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

    public function format(mixed $input): mixed
    {
        if (! $input) {
            return $this->default;
        }

        return $this->enum::tryFrom($input);
    }
}
