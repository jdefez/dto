<?php

namespace Ayctor\Dto\Concerns;

use Ayctor\Dto\Contracts\IsCastContract;
use Ayctor\Dto\Contracts\IsValidatorContract;
use Ayctor\Dto\Contracts\IsVisibilityContract;
use Illuminate\Support\Collection;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionProperty;

trait IsDto
{
    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public static function make(object|array $attributes): static
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();
        $properties = $constructor->getParameters();
        $keys = array_keys((array) $attributes);
        $args = [];

        foreach ($properties as $property) {
            $name = $property->getName();
            $value = data_get($attributes, $name) ?? self::getPropertyDefaultValue($property);

            self::handleValidations($property, $value);

            $value = self::handleCasts($property, $value);

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
            $value = $property->getValue($this);

            if ($this->propertyIsHidden($property, $value)) {
                continue;
            }

            $name = $property->getName();

            $return[$name] = $value;
        }

        return $return;
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function propertyIsHidden(
        ReflectionProperty $property,
        mixed $value
    ): bool {
        return self::getAttributesByType($property, IsVisibilityContract::class)
            ->some(fn (ReflectionAttribute $attribute) => $attribute
                ->newInstance()
                ->shouldHide($value));
    }

    private static function handleCasts(
        ReflectionParameter $parameter,
        mixed $value
    ): mixed {
        foreach (self::getAttributesByType($parameter, IsCastContract::class) as $attribute) {
            $value = $attribute->newInstance()->format($value);
        }

        return $value;
    }

    private static function handleValidations(
        ReflectionParameter $parameter,
        mixed $value
    ): void {

        foreach (self::getAttributesByType($parameter, IsValidatorContract::class) as $attribute) {
            $attribute->newInstance()->isValid(
                $value,
                $parameter->getName()
            );
        }
    }

    private static function getPropertyDefaultValue(
        ReflectionParameter $property
    ): mixed {
        try {
            return $property->getDefaultValue();
        } catch (ReflectionException) {
            return null;
        }
    }

    /**
     * @param  class-string  $type
     * @return Collection<ReflectionAttribute>
     */
    private static function getAttributesByType(
        ReflectionParameter|ReflectionProperty $property,
        string $type
    ): Collection {
        return new Collection($property->getAttributes(
            $type,
            ReflectionAttribute::IS_INSTANCEOF
        ));
    }
}
