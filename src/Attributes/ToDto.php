<?php

namespace Ayctor\Dto\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ToDto implements IsCastContract
{
    /**
     * @param  class-string  $dto
     */
    public function __construct(
        public string $dto,
    ) {}

    public function format(mixed $input): mixed
    {
        if (is_array($input) || is_object($input)) {
            return $this->dto::make($input);
        }

        return null;
    }
}
