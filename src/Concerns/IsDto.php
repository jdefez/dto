<?php

namespace Jdefez\Dto\Concerns;

use Illuminate\Support\Collection;
use Jdefez\Dto\Contracts\IsCastContract;
use Jdefez\Dto\Contracts\IsValidatorContract;
use Jdefez\Dto\Contracts\IsVisibilityContract;
use Jdefez\Dto\Exceptions\MissingAttributeException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionProperty;

trait IsDto
{
    /**
     * @param  object|array<array-key, mixed>  $attributes
     *
     * @throws MissingAttributeException
     */
    public static function make(object|array $attributes): static
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();
        $parameters = $constructor->getParameters();
        $keys = array_keys((array) $attributes);
        $args = [];

        self::validateAttributes($parameters, $keys);

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $value = data_get($attributes, $name) ?? self::getPropertyDefaultValue($parameter);

            self::handleValidations($parameter, $value, $attributes);

            $value = self::handleCasts($parameter, $value, $attributes);

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

    /**
     * @param  array<ReflectionParameter>  $properties
     * @param  array<string>  $attribut_keys
     *
     * @throws MissingAttributeException
     */
    private static function validateAttributes(
        array $properties,
        array $attribut_keys
    ): void {
        $required = (new Collection($properties))
            ->filter(fn (ReflectionParameter $property) => ! $property->isOptional())
            ->map(fn (ReflectionParameter $property) => $property->getName());

        if ($required->some(fn ($item) => ! in_array($item, $attribut_keys))) {
            $missing = $required->diff($attribut_keys);

            throw new MissingAttributeException(
                "Missing attribute {$missing->join(', ', ' and ')}."
            );
        }
    }
}
