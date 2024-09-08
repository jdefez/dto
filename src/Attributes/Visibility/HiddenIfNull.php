<?php

namespace Ayctor\Dto\Attributes\Visibility;

use Attribute;
use Ayctor\Dto\Contracts\IsVisibilityContract;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HiddenIfNull implements IsVisibilityContract
{
    public function __construct(
    ) {}

    public function shouldHide(mixed $value): bool
    {
        return is_null($value);
    }
}
