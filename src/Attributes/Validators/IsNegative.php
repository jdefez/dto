<?php

namespace Ayctor\Dto\Attributes\Validators;

use Attribute;
use Ayctor\Dto\Contracts\IsValidatorContract;
use Ayctor\Dto\Exceptions\ValidationException;

#[Attribute(Attribute::TARGET_PARAMETER)]
class IsNegative implements IsValidatorContract
{
    public function __construct(
    ) {}

    /**
     * @throws ValidationException
     */
    public function isValid(mixed $input, string $attribute): void
    {
        if (! is_numeric($input) || $input > 0) {
            throw new ValidationException(
                "The attribute $attribute must be negative '$input' given."
            );
        }
    }
}
