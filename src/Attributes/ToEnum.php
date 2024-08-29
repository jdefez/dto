<?php

namespace Ayctor\Dto\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToEnum implements IsCastContract
{
    /**
     * @param class-string $enum
     */
    public function __construct(
        public string $enum,
    ) {}

    public function format(mixed $input): mixed
    {
        if (! $input) {
            return null;
        }

        return $this->enum::tryFrom($input);
    }
}
