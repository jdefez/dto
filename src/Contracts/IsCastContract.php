<?php

namespace Ayctor\Dto\Contracts;

interface IsCastContract
{
    /**
     * Format the input value.
     *
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, array|object $attributes): mixed;
}
