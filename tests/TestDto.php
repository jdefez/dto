<?php

namespace Ayctor\Tests;

use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Traits\HasArrayableProperties;

class TestDto
{
    use HasArrayableProperties;

    public function __construct(
        public string $name,

        #[HiddenIfNull]
        public ?int $id = null,
    ) {}
}
