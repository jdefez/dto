<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Attributes\Casts\ToDto;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;

final class ToDtoFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
        #[ToDto(RoleDtoFixture::class)]
        public ?RoleDtoFixture $role,
    ) {}
}
