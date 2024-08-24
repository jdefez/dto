<?php

namespace Ayctor\Dto\Contracts;

interface IsCastContract
{
    /**
     * Format the input value.
     */
    public function format(mixed $input): mixed;
}
