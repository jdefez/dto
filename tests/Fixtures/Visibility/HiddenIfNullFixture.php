<?php

namespace Jdefez\Tests\Fixtures\Visibility;

use Jdefez\Dto\Attributes\Visibility\HiddenIfNull;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

final class HiddenIfNullFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
