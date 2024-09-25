<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Attributes\Casts\StrToCarbon;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;
use Carbon\Carbon;

final class StrToCarbonFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        #[StrToCarbon(from_format: 'd/m/Y')]
        readonly public Carbon $date,
    ) {}
}
