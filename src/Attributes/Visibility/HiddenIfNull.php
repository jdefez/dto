<?php

namespace Ayctor\Dto\Attributes\Visibility;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HiddenIfNull
{
    public function __construct(
    ) {}
}
