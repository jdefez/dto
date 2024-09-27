<?php

namespace Jdefez\Tests\Fixtures\Validators;

use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Tests\Fixtures\Attributes\CustomValidator;

final class CustomValidatorFixture
{
    use IsDto;

    public function __construct(
        #[CustomValidator]
        readonly public string $start_at,

        #[CustomValidator]
        readonly public string $end_at,
    ) {}
}
