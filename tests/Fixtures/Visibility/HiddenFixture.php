<?php

namespace Ayctor\Tests\Fixtures\Visibility;

use Ayctor\Dto\Attributes\Visibility\Hidden;
use Ayctor\Dto\Concerns\IsDto;

final class HiddenFixture
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        #[Hidden]
        readonly public ?int $id = null,
    ) {}
}
