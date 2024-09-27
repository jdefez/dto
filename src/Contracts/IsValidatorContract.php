<?php

namespace Jdefez\Dto\Contracts;

use Jdefez\Dto\Exceptions\ValidationException;

interface IsValidatorContract
{
    /**
     * @param  object|array<array-key, mixed>  $attributes
     *
     * @throws ValidationException
     */
    public function isValid(
        mixed $input,
        string $attribute,
        object|array $attributes
    ): void;
}
