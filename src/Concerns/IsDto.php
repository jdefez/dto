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
use Ayctor\Dto\Exceptions\ValidationException;
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

            // Validation

            if (self::hasAttribute(IsPositive::class, $property)) {
                self::validateUsing(IsPositive::class, $property, $value);
            }

            // Casts

            if (self::hasAttribute(StrToCarbon::class, $property)) {
                $value = self::castUsing(StrToCarbon::class, $property, $value);
            }

            if (self::hasAttribute(ArrayToCollection::class, $property)) {
                $value = self::castUsing(ArrayToCollection::class, $property, $value);
            }

            if (self::hasAttribute(ToDto::class, $property)) {
                $value = self::castUsing(ToDto::class, $property, $value);
            }

            if (self::hasAttribute(ToEnum::class, $property)) {
                $value = self::castUsing(ToEnum::class, $property, $value);
            }

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
    private static function getAttributesNames(array $attributes): array
    {
        return array_map(fn ($attribute) => $attribute->getName(), $attributes);
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     * @param  class-string  $attribute
     */
    private static function castUsing(string $attribute, ReflectionParameter $property, mixed $value): mixed
    {
        $attributes = $property->getAttributes();
        $instance = self::getAttribute($attribute, $attributes)?->newInstance();
        $ref = new ReflectionClass($instance);

        if (! $instance || ! $ref->implementsInterface(IsCastContract::class)) {
            return $value;
        }

        return $instance->format($value);
    }

    /**
     * @param  array<ReflectionAttribute>  $attributes
     * @param  class-string  $attribute
     *
     * @throws ValidationException
     */
    private static function validateUsing(string $attribute, ReflectionParameter $property, mixed $value): void
    {
        $attributes = $property->getAttributes();
        $instance = self::getAttribute($attribute, $attributes)?->newInstance();
        $ref = new ReflectionClass($instance);

        if (! $instance || ! $ref->implementsInterface(IsValidatorContract::class)) {
            return;
        }

        $instance->isValid($value, $property->getName());
    }

    /**
     * @param  array<int,mixed>  $attributes
     * @param  class-string  $attribute
     */
    private static function getAttribute(string $attribute, array $attributes): ?ReflectionAttribute
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
    private static function hasAttribute(string $attribute, ReflectionParameter $property): bool
    {
        $attributes = $property->getAttributes();

        return in_array($attribute, self::getAttributesNames($attributes));
    }

    private static function getPropertyDefaultValue(ReflectionParameter $property): mixed
    {
        try {
            return $property->getDefaultValue();
        } catch (ReflectionException) {
            return null;
        }
    }
}
