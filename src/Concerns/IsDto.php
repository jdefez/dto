<?php

namespace Ayctor\Dto\Concerns;

use Ayctor\Dto\Attributes\Casts\ArrayToCollection;
use Ayctor\Dto\Attributes\Visibility\Hidden;
use Ayctor\Dto\Attributes\Visibility\HiddenIfNull;
use Ayctor\Dto\Attributes\Validators\IsPositive;
use Ayctor\Dto\Attributes\Casts\StrToCarbon;
use Ayctor\Dto\Attributes\Casts\ToDto;
use Ayctor\Dto\Attributes\Casts\ToEnum;
use Ayctor\Dto\Contracts\IsCastContract;
use Ayctor\Dto\Contracts\IsValidatorContract;
use Ayctor\Dto\Contracts\IsVisibilityContract;
use Ayctor\Dto\Exceptions\ValidationException;
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
        $keys = array_keys($attributes);
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
            if ($this->propertyIsHidden($property)) {
                continue;
            }

            $name = $property->getName();
            $value = $property->getValue($this);

            $return[$name] = $value;
        }

        return $return;
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     */
    private function propertyIsHidden(ReflectionProperty $property): bool
    {
        return self::getAttributesByType($property, IsVisibilityContract::class)
            ->isNotEmpty();
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
     * @param class-string $type
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
