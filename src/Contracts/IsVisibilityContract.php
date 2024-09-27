<?php

namespace Jdefez\Dto\Contracts;

interface IsVisibilityContract
{
    public function shouldHide(mixed $value, DtoContract $dto): bool;
}
