<?php

namespace Ayctor\Tests\Dtos;

use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Attributes\StrToCarbon;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Carbon\Carbon;

final class UserDto implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        readonly public string $lastname,

        #[StrToCarbon('d/m/Y H:i:s', 'Europe/Paris')]
        readonly public Carbon $created_at,

        #[Hidden]
        readonly public ?string $password = null,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
