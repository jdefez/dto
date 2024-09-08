<?php

namespace Ayctor\Tests\Fixtures\Casts;

use Ayctor\Dto\Attributes\Casts\ArrayToCollection;
use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use Illuminate\Support\Collection;

final class ArrayToCollectionFixture implements DtoContract
{
    use IsDto;

    /**
     * @param  ?Collection<int, int>  $users
     */
    public function __construct(
        #[ArrayToCollection]
        public ?Collection $users
    ) {}
}
