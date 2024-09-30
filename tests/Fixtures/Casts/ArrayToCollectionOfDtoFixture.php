<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Illuminate\Support\Collection;
use Jdefez\Dto\Attributes\Casts\ArrayToCollection;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

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
