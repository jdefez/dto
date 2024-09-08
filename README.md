# AYCTOR DTO

Is designed to convert a class to a Data Transfer Object by simply adding a trait
(IsDto) and customizing its properties with provided Attributes.

___

## TODO:

### Refactor

Refactor/optimize IsDto with : `$attrs = $reflector->getAttributes(BaseAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);`
cf: [PHP 8.0: Attributes](https://php.watch/versions/8.0/attributes)
> **At the moment, only \ReflectionAttribute::IS_INSTANCEOF is available.**
> If \ReflectionAttribute::IS_INSTANCEOF is passed, the return array will contain
> Attribute with same class name or classes that extends or implements
> the provided name (i.e all classes that fulfull instanceOf $name).

```php
$property = new ReflectionProperty('Basket', 'apple');
$attributes = $property->getAttributes(ColorContract::class, ReflectionAttribute::IS_INSTANCEOF);
print_r(array_map(fn($attribute) => $attribute->getName(), $attributes));
```

### Tests
  * [x] test cast attribute + visibility attribute

### Casts attributes: 
  - [x] implement fallback value for all casts attributes,
  * [ ] ToFloat,
  - [ ] ToCast,
  * [ ] ToPeriod(start_attribute_name, end_attribute_name)

### Validation attriubtes: 
  * [x] IsPositive
  - [ ] IsBetween
  - [ ] IsNegative

 ___

## Methods provided

 * (static) _make(object|array): DtoContract_ to build a dto class from an array or object
 * _toArray(): array_ method

**It can:**

 * Cast the input values before the class properties instanciation through the _make_ method;
 - Validate input values;
 * Hide some attributes when the method toArray() is called

# Available attributes

## Casts

Casts the input value when instanciating the class properties.

| Name | Description | Parameters |
| --- | --- | --- |
| StrToCarbon | Casts the attribute to a Carbon instance | @from_format (?string), @timezone (?string) |
| ArrayToCollection | Casts the attribute to a Collection | @dto (?class-string) |
| ToDto | Casts the attribute to a Dto | @dto (class-string) |
| ToEnum | Casts the attribute to enum | @enum (class-string) |

## Validators

Validate the input values before class properties instanciation.

| Name | Description | Parameters |
| --- | --- | --- |
| IsPositive | The input value is positive | - |

## visibility

The attribute are absente for the array returned by the method toArray.

| Name | Description | Parameters |
| --- | --- | --- |
| Hidden | Hides the attribute when toArray() is applied | - |
| HiddenIfNull | Hides the attribute when  when toArray() is applied and its value is null | - |

## example

Defining a UserDto class

```php
<?php

namespace App\Dtos;

use Ayctor\Dto\Attributes\Hidden;
use Ayctor\Dto\Attributes\HiddenIfNull;
use Ayctor\Dto\Contracts\DtoContract;
use Ayctor\Dto\Traits\IsDto;

class UserDto implements DtoContract
{
    use IsDto;

    public function __construct(
        readonly public string $firstname,

        readonly public string $lastname,

        #[Hidden] // this property will always be hidden when converted to array
        readonly public string $password,

        #[HiddenIfNull] // this property will be hidden when its value is null
        readonly public ?int $id = null,
    ) {}
}
```

Using the UserDto class

```php
$dto = UserDto::make([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'password' => '$password',
])

dump($dto->toArray());

// output
//
// [
//     'firstname' => 'John',
//     'lastname' => 'Doe',
// ]
```
