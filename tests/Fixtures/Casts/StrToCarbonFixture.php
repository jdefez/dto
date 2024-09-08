<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Attributes\Casts\StrToCarbon;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Carbon\Carbon;

final class StrToCarbonFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        #[StrToCarbon(from_format: 'd/m/Y')]
        readonly public Carbon $date,
    ) {}
}
