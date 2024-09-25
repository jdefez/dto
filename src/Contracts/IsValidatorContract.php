<?php

namespace Jdefez\Dto\Contracts;

use Jdefez\Dto\Exceptions\ValidationException;

interface IsValidatorContract
{
    /**
     * @throws ValidationException
     */
    public function isValid(mixed $input, string $attribute): void;
}
