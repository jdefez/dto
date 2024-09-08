<?php

namespace Ayctor\Tests\Fixtures\Validators;

use Ayctor\Dto\Attributes\Validators\IsPositive;
use Ayctor\Dto\Concerns\IsDto;

final class IsPositiveFixture
{
    use IsDto;

    public function __construct(
        #[IsPositive]
        readonly public int $number,
    ) {}
}
