<?php

namespace Ayctor\Dto\Attributes\Visibility;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Hidden
{
    public function __construct(
    ) {}
}