<?php

namespace Ayctor\Dto\Contracts;

interface IsVisibilityContract
{
    public function shouldHide(mixed $value): bool;
}
