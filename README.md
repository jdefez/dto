# AYCTOR DTO

Is designed to convert a class to a Data Transfer Object by simply adding a trait
(IsDto) and customizing its properties with provided Attributes.

___

## TODO:

- [ ] Pass all attributes to the Casts and Validators classes _(-> ToCast, -> Validator)_

### Tests
* [x] Test cast attribute + visibility attribute

### Casts attributes: 
- [ ] Add from_timezone and to_timezone
- [x] Implement fallback value for all casts attributes,
* [ ] ToFloat,
- [ ] ToInt
- [ ] ToString
- [ ] ToObject
- [ ] ToCast,

### Validation attriubtes: 
* [x] IsPositive
- [x] IsNegative
- [ ] Validator

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
| ToFloat | Casts the attribute to float | @precision (int) default = 1 |
| ToInt | Casts the attribute to int | |
| _ToString (?)_ | Casts the attribute to string | |
| _ToObject (?)_ | Casts the attribute to object | |

### Custom cats attributes

You can also implement your custom casts attributes providing they implements the interface `IsCastContract`.

#### Custom implementation

```php
<?php

namespace App\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;

#[Attribute(Attribute::TARGET_PARAMETER)]
class FullnameCastAttribut implements IsCastContract
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
```

#### Usage:

```php
<?php

namespace App\Dtos;

use Ayctor\Dto\Concerns\IsDto;
use Ayctor\Dto\Contracts\DtoContract;
use App\Attributes\FullnameCastAttribut;

final class CustomCastFixture implements DtoContract
{
    use IsDto;

    public function __construct(
        public string $firstname,
        public string $lastname,
        #[FullnameCastAttribut]
        public string $fullname
    ) {}
}
```

## Validators

Validate the input values before class properties instanciation.

Throws: ValidationException

| Name | Description | Parameters |
| --- | --- | --- |
| IsPositive | The input value is positive | - |
| IsNegative | The input value is negative | - |

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

See tests classes for more examples

