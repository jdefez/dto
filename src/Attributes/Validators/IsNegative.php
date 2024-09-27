<?php

namespace Jdefez\Dto\Attributes\Validators;

use Attribute;
use Jdefez\Dto\Contracts\IsValidatorContract;
use Jdefez\Dto\Exceptions\ValidationException;

#[Attribute(Attribute::TARGET_PARAMETER)]
class IsNegative implements IsValidatorContract
{
    /**
     * @param  object|array<array-key, mixed>  $attributes
     *
     * @throws ValidationException
     */
    public function isValid(
        mixed $input,
        string $attribute,
        array|object $attributes
    ): void {
        if (! is_numeric($input) || $input > 0) {
            throw new ValidationException(
                "The attribute $attribute must be negative '$input' given."
            );
        }
    }
}
