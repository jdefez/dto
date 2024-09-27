<?php

namespace Jdefez\Tests\Fixtures\Visibility;

use Jdefez\Dto\Attributes\Visibility\Hidden;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

final class HiddenFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[Hidden]
        readonly public ?int $id = null,
    ) {}
}
