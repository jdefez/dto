<?php

namespace Jdefez\Tests\Fixtures\Visibility;

use Jdefez\Dto\Attributes\Visibility\HiddenIfNull;
use Jdefez\Dto\Concerns\IsDto;

final class HiddenIfNullFixture
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
