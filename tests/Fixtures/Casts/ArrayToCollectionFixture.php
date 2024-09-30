<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Illuminate\Support\Collection;
use Jdefez\Dto\Attributes\Casts\ArrayToCollection;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;

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
