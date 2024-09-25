# DTO trait

**It can:**

 - Turn a simple class into a dto via the _make_ method which handles an array or on object;
 * Its properties values are casted and validated at instanciation;
 * The method _toArray_ can hide some properties via the visibility attributes.

[Implementation](#implementation)
[Methods](#methods)
[Available attributes](#methods)
 1. [Casts Attributes](#casts-attributes)
  * [Custom casts Attributes](#custom-casts-attributes)
 2. [Validators Attributes](#validators-attributes)
 3. [Visibility Attributes](#visibility-attributes)

## <a name="implementation"></a>Implementing a Dto

```php
<?php

namespace App\Dtos;

use Jdefez\Dto\Attributes\Hidden;
use Jdefez\Dto\Attributes\HiddenIfNull;
use Jdefez\Dto\Contracts\DtoContract;
use Jdefez\Dto\Traits\IsDto;

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

**Using the Dto class**

**TODO: improve example

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

## <a name="methods"></a>Methods provided

**public static make(object|array): DtoContract** To build a dto class from an array or object and **toArray(): array**.

# <a name="attributes"></a>Available attributes

## <a name="casts-attributes"></a>1. Casts Attributes

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

### <a name="custom-casts-attributes"></a>Custom cast attributes

You can also implement your custom casts attributes providing they implements the interface `IsCastContract`.

#### Custom cast attribute implementation

```php
<?php

namespace App\Attributes;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;

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

#### Custom cast attribute in use case:

```php
<?php

namespace App\Dtos;

use Jdefez\Dto\Concerns\IsDto;
use Jdefez\Dto\Contracts\DtoContract;
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

## <a name="validators-attributes"></a>2. Validators attributes

Validate the input values before class properties instanciation.

Throws: ValidationException

| Name | Description | Parameters |
| --- | --- | --- |
| IsPositive | The input value is positive | - |
| IsNegative | The input value is negative | - |

## <a name="visibility-attributes"></a>3. Visibility attributes

The properties flaged with a visibility attribute are removed/hidden from the array returned by the method toArray.

| Name | Description | Parameters |
| --- | --- | --- |
| Hidden | Hides the attribute when toArray() is applied | - |
| HiddenIfNull | Hides the attribute when  when toArray() is applied and its value is null | - |
### Nesting Dtos

**TODO:** describe

___

## TODO:

- [x] Pass all attributes to the Casts and Validators classes _(-> ToCast, -> Validator)_

### Tests
* [x] Test cast attribute + visibility attribute

### Casts attributes: 
- [ ] Add from_timezone and to_timezone
- [x] Implement fallback value for all casts attributes,
* [x] ToFloat,
- [x] ToInt
- [ ] ToString
- [ ] ToObject

### Validation attriubtes: 
* [x] IsPositive
- [x] IsNegative
- [ ] Validator (custom validator ?) test + doc custom validator (with multiple attributes)

### Custom visibility attribute
