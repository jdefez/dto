<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Attributes\Casts\ToEnum;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

final class EnumFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,

        #[ToEnum(StatusEnum::class, 6)]
        public StatusEnum $status,
    ) {}
}
