<?php

namespace Jdefez\Tests\Fixtures\Casts;

use Jdefez\Dto\Attributes\Casts\ArrayToCollection;
use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;
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
