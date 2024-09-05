<?php

namespace Ayctor\Tests\Samples;

use Ayctor\Dto\Attributes\Casts\ArrayToCollection;
use Ayctor\Dto\Attributes\Visibility\Hidden;
use Ayctor\Dto\Attributes\Visibility\HiddenIfNull;
use Ayctor\Dto\Attributes\Validators\IsPositive;
use Ayctor\Dto\Attributes\Casts\StrToCarbon;
use Ayctor\Dto\Attributes\Casts\ToDto;
use Ayctor\Dto\Attributes\Casts\ToEnum;
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

        #[IsPositive]
        readonly public int $age,

        #[Hidden]
        #[ToEnum(UserStatus::class)]
        readonly public UserStatus $status,

        #[StrToCarbon('d/m/Y H:i:s', 'Europe/Paris')]
        readonly public Carbon $created_at,

        #[ArrayToCollection(RoleDto::class)]
        readonly public ?Collection $roles,

        #[ToDto(UserDto::class)]
        readonly public ?UserDto $manager = null,

        #[Hidden]
        readonly public ?string $password = null,

        #[HiddenIfNull]
        readonly public ?int $id = null,
    ) {}
}
