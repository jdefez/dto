<?php

namespace Ayctor\Tests\Dtos;

use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;

class RolesDto implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
        public int $id,
    ) {}
}
