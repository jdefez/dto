<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Attributes\Casts\ArrayToCollection;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;
use Illuminate\Support\Collection;

final class ArrayToCollectionOfDtoFixture implements DtoContract
{
    use IsDto;

    /**
     * @param  Collection<int, RoleDtoFixture>  $roles
     */
    public function __construct(
        #[ArrayToCollection(RoleDtoFixture::class)]
        public Collection $roles
    ) {}
}
