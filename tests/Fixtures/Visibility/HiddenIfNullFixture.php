<?php

namespace Ayctor\Tests\Fixtures\Visibility;

use Ayctor\Dto\Attributes\Visibility\HiddenIfNull;
use Ayctor\Dto\Concerns\IsDto;

final class HiddenIfNullFixture
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
