<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Attributes\Casts\ToDto;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

final class ToDtoFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,
        #[ToDto(RoleDtoFixture::class)]
        public ?RoleDtoFixture $role,
    ) {}
}
