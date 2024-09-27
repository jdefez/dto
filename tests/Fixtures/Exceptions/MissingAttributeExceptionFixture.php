<?php

namespace Jdefez\Tests\Fixtures\Exceptions;

use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

final class MissingAttributeExceptionFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,
        readonly public string $lastname,
        readonly public ?string $email = null,
    ) {}
}
