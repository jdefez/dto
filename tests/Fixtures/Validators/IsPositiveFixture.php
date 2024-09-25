<?php

namespace Jdefez\Tests\Fixtures\Validators;

use Jdefez\Dto\Attributes\Validators\IsPositive;
use Jdefez\Dto\Concerns\IsDto;

final class IsPositiveFixture
{
    use IsDto;

    public function __construct(
        #[IsPositive]
        readonly public int $number,
    ) {}
}
