<?php

namespace Ayctor\Tests;

use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Contracts\DtoContract;
use Ayctor\Dto\Traits\IsDto;

class TestDto implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        readonly public string $lastname,

        #[Hidden]
        readonly public string $password,

        #[HiddenIfNull]
        readonly public ?int $id = null,

        readonly public ?string $created_at = null,
    ) {}
}
