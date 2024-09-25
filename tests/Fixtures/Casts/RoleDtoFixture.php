<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

class RoleDtoFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
    ) {}
}
