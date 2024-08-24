<?php

namespace Ayctor\Dto\Traits;

use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Attributes\StrToCarbon;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

trait IsDto
{
    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function make(array $attributes): static
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();
        $properties = $constructor->getParameters();
        $keys = array_keys($attributes);
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

            // Casts

            if ($this->hasAttribute(StrToCarbon::class, $attributes)) {
                $value = $this->castUsing(StrToCarbon::class, $attributes, $value);
            }

            $return[$name] = $value;
        }

        return $return;
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function propertyIsHidden(array $attributes, mixed $value): bool
    {
        if ($value === null
            && in_array(HiddenIfNull::class, $this->getAttributesNames($attributes))
        ) {
            return true;
        }

        return in_array(Hidden::class, $this->getAttributesNames($attributes));
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function getAttributesNames(array $attributes): array
    {
        return array_map(fn ($attribute) => $attribute->getName(), $attributes);
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function castUsing(string $attribute, array $attributes, mixed $value): mixed
    {
        $instance = $this->getAttribute(StrToCarbon::class, $attributes)?->newInstance();

        if (! $instance) {
            return $value;
        }

        // TODO:
        // - check the attribute instance is an instance of IsCastContract
        // - implement the test

        return $instance->format($value);
    }

    /**
     * @param  array<int,mixed>  $attributes
     */
    private function getAttribute(string $attribute, array $attributes): ?ReflectionAttribute
    {
        foreach ($attributes as $attr) {
            if ($attr->getName() === $attribute) {
                return $attr;
            }
        }

        return null;
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function hasAttribute(string $attribute, array $attributes): bool
    {
        return in_array($attribute, $this->getAttributesNames($attributes));
    }
}
