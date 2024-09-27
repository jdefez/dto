<?php

namespace Jdefez\Tests\Fixtures\Attributes;

use Attribute;
use Carbon\Carbon;
use Jdefez\Dto\Contracts\IsValidatorContract;
use Jdefez\Dto\Exceptions\ValidationException;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CustomValidator implements IsValidatorContract
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
        $start_at = Carbon::parse(data_get($attributes, 'start_at'));
        $end_at = Carbon::parse(data_get($attributes, 'end_at'));

        if (! $start_at->isBefore($end_at)) {
            throw new ValidationException('Invalid start_at and end_at dates.');
        }
    }
}
