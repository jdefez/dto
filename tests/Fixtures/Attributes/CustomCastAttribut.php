<?php

namespace Ayctor\Tests\Fixtures\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;

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
        if (is_object($attributes)
            && property_exists($attributes, 'firstname')
            && property_exists($attributes, 'lastname')
        ) {
            return $attributes->firstname.' '.$attributes->lastname;
        }

        if (is_array($attributes)
            && array_key_exists('firstname', $attributes)
            && array_key_exists('lastname', $attributes)
        ) {
            return $attributes['firstname'].' '.$attributes['lastname'];
        }

        return $this->default;
    }
}
