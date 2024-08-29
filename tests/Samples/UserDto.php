<?php

namespace Ayctor\Tests\Samples;

use Ayctor\Dto\Attributes\ArrayToCollection;
use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Attributes\StrToCarbon;
use Ayctor\Dto\Attributes\ToDto;
use Ayctor\Dto\Attributes\ToEnum;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class UserDto implements DtoContract
{
    use IsDto;

    /**
     * @param  Collection<int, RoleDto>  $roles
     */
    public function __construct(
        readonly public string $firstname,

        readonly public string $lastname,

        #[Hidden]
        #[ToEnum(UserStatus::class)]
        readonly public UserStatus $status,

        #[StrToCarbon('d/m/Y H:i:s', 'Europe/Paris')]
        readonly public Carbon $created_at,

        #[ArrayToCollection(RoleDto::class)]
        readonly public Collection $roles,

        #[ToDto(UserDto::class)]
        readonly public ?UserDto $manager = null,

        #[Hidden]
        readonly public ?string $password = null,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
