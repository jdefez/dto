<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Attributes\Casts\ArrayToCollection;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
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
