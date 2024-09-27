<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;
use Jdefez\Tests\Fixtures\Attributes\CustomCastAttribut;

final class CustomCastFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $firstname,
        public string $lastname,
        #[CustomCastAttribut]
        public ?string $fullname = null
    ) {}
}
