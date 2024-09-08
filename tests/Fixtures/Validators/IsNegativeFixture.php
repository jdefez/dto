<?php

namespace Ayctor\Tests\Fixtures\Validators;

use Ayctor\Dto\Attributes\Validators\IsNegative;
use Ayctor\Dto\Concerns\IsDto;

final class IsNegativeFixture
{
    use IsDto;

    public function __construct(
        #[IsNegative]
        readonly public int $number,
    ) {}
}
