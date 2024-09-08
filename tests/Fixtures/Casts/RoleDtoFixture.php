<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;

class RoleDtoFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
    ) {}
}
