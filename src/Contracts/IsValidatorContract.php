<?php

namespace Ayctor\Dto\Contracts;

use Ayctor\Dto\Exceptions\ValidationException;

interface IsValidatorContract
{
    /**
     * @throws ValidationException
     */
    public function isValid(mixed $input, string $attribute): void;
}
