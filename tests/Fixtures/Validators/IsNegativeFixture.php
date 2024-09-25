<?php

namespace Jdefez\Tests\Fixtures\Validators;

use Jdefez\Dto\Attributes\Validators\IsNegative;
use Jdefez\Dto\Concerns\IsDto;

final class IsNegativeFixture
{
    use IsDto;

    public function __construct(
        #[IsNegative]
        readonly public int $number,
    ) {}
}
