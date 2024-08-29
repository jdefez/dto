<?php

namespace Ayctor\Tests\Samples;

use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;

class RoleDto implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
        public int $id,
    ) {}
}
