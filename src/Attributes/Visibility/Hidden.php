<?php

namespace Jdefez\Dto\Attributes\Visibility;

use Attribute;
use Jdefez\Dto\Contracts\DtoContract;
use Jdefez\Dto\Contracts\IsVisibilityContract;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Hidden implements IsVisibilityContract
{
    public function shouldHide(mixed $value, DtoContract $dto): bool
    {
        return true;
    }
}
