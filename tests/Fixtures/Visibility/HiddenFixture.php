<?php

namespace Jdefez\Tests\Fixtures\Visibility;

use Jdefez\Dto\Attributes\Visibility\Hidden;
use Jdefez\Dto\Concerns\IsDto;

final class HiddenFixture
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[Hidden]
        readonly public ?int $id = null,
    ) {}
}
