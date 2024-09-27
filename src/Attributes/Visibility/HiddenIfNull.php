<?php

namespace Jdefez\Dto\Attributes\Visibility;

use Attribute;
use Jdefez\Dto\Contracts\DtoContract;
use Jdefez\Dto\Contracts\IsVisibilityContract;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HiddenIfNull implements IsVisibilityContract
{
    public function shouldHide(mixed $value, DtoContract $dto): bool
    {
        return is_null($value);
    }
}
