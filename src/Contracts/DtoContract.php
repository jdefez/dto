<?php

namespace Ayctor\Dto\Contracts;

interface DtoContract
{
    /**
     * Create a new instance of the DTO.
     *
     * @param  object|array<array-key, mixed>  $attributes
     */
    public static function make(object|array $attributes): static;

    /**
     * Convert the DTO to an array.
     *
     * @return array<array-key, mixed>
     */
    public function toArray(): array;
}
