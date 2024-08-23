<?php

namespace Ayctor\Dto\Traits;

use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use ReflectionClass;
use ReflectionProperty;

trait HasArrayableProperties
{
    /**
     * @param array<array-key, mixed> $properties
     */
    public static function make(array $attributes): static
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();
        $properties = $constructor->getParameters();
        $keys =  array_keys($attributes);

        $args = [];
        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $attributes[$name] ?? $property->getDefaultValue();

            $args[] = $value;
        }

        return new static(...$args);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function toArray(): array
    {
        $return = [];

        $ref = new ReflectionClass($this);
        $properties = $ref->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $property->getValue($this);
            $attributes = $property->getAttributes();

            if ($this->propertyIsHidden($attributes, $value)) {
                continue;
            }

            $return[$name] = $value;
        }

        return $return;
    }

    /**
     * @param array<ReflectionAttribute> $attributes
     */
    private function propertyIsHidden(array $attributes, mixed $value): bool
    {
        if ($value === null
            && in_array(HiddenIfNull::class, $this->getAttributesNames($attributes))
        ) {
            return true;
        }

        return in_array( Hidden::class, $this->getAttributesNames($attributes));
    }

    /**
     * @param array<ReflectionAttribute> $attributes
     */
    private function getAttributesNames(array $attributes): array
    {
        return array_map(fn($attribute) => $attribute->getName(), $attributes);
    }
}
