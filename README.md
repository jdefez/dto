# AYCTOR DTO

Is designed to convert a class to a Data Transfer Object by simply adding a trait
(IsDto) and customizing its properties with provided Attributes.

___

## TODO:
 - test: cast attribute + visibility attribute
 ___

**Methods provided:**

 * (static) make(object|array) to build a dto class from an array
 * and a toArray(): array method

**It can:**

 * Hide some attributes when the method toArray() is called
 * Cast the dto properties using php Attributes

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

# Available attributes

| Name | Description | Parameters |
| --- | --- | --- |
| Hidden | Hides the attribute when toArray() is applied | - |
| HiddenIfNull | Hides the attribute when  when toArray() is applied and its value is null | - |
| StrToCarbon | Casts the attribute to a Carbon instance | @from_format (?string), @timezone (?string) |
| ArrayToCollection | Casts the attribute to a Collection | @dto (?class-string) |
| ToDto | Casts the attribute to a Dto | @dto (class-string) |
