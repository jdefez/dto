<?php

namespace Ayctor\Dto\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class HiddenIfNull
{
    public function __construct(
    ) {}
}
