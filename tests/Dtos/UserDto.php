<?php

namespace Ayctor\Tests\Dtos;

use Ayctor\Dto\Attributes\ArrayToCollection;
use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Attributes\StrToCarbon;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class UserDto implements DtoContract
{
    use IsDto;

    /**
     * @param  Collection<int, RolesDto>  $roles
     */
    public function __construct(
        readonly public string $firstname,

        readonly public string $lastname,

        #[StrToCarbon('d/m/Y H:i:s', 'Europe/Paris')]
        readonly public Carbon $created_at,

        #[ArrayToCollection(RolesDto::class)]
        readonly public Collection $roles,

        #[Hidden]
        readonly public ?string $password = null,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
