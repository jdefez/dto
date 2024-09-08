<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Attributes\Casts\ToEnum;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;

final class EnumFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $name,

        #[ToEnum(StatusEnum::class, 6)]
        public StatusEnum $status,
    ) {}
}
