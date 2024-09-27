<?php

namespace Jdefez\Tests\Fixtures\Attributes;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CustomCastAttribut implements IsCastContract
{
    public function __construct(
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): ?string
    {
        $firstname = data_get($attributes, 'firstname');
        $lastname = data_get($attributes, 'lastname');

        if (! $firstname && ! $lastname) {
            return $this->default;
        }

        return $firstname.' '.$lastname;
    }
}
