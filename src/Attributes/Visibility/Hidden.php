<?php

namespace Ayctor\Dto\Attributes\Visibility;

use Attribute;
use Ayctor\Dto\Contracts\IsVisibilityContract;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Hidden implements IsVisibilityContract
{
    public function __construct(
    ) {}
}
