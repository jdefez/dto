<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Ayctor\Tests\Fixtures\Attributes\CustomCastAttribut;

final class CustomCastFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $firstname,
        public string $lastname,
        #[CustomCastAttribut]
        public string $fullname
    ) {}
}
