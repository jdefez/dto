<?php

namespace Jdefez\Dto\Concerns;

use Illuminate\Support\Collection;
use Jdefez\Dto\Contracts\IsCastContract;
use Jdefez\Dto\Contracts\IsValidatorContract;
use Jdefez\Dto\Contracts\IsVisibilityContract;
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

            self::handleValidations($property, $value, $attributes);

            $value = self::handleCasts($property, $value, $attributes);

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
                ->shouldHide($value, $this));
    }

    private static function handleCasts(
        ReflectionParameter $parameter,
        mixed $value,
        object|array $attributes,
    ): mixed {
        foreach (self::getAttributesByType($parameter, IsCastContract::class) as $attribute) {
            $value = $attribute->newInstance()->format($value, $attributes);
        }

        return $value;
    }

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    private static function handleValidations(
        ReflectionParameter $parameter,
        mixed $value,
        object|array $attributes,
    ): void {

        foreach (self::getAttributesByType($parameter, IsValidatorContract::class) as $attribute) {
            $attribute->newInstance()
                ->isValid(
                    $value,
                    $parameter->getName(),
                    $attributes
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
