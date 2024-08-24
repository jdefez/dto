# Ayctor Dto

Is designed to convert a class to a Data Transfer Object by simply adding a trait (IsDto) and customizing its properties with provided Attributes.

For example

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

# Usage

```php
$dto = UserDto::make([
    'firstname' => 'John',
    'lastname' => 'Doe',
    'password' => '$password',
])

var_dump($dto->toArray());

// outputs
//
// [
//     'firstname' => 'John',
//     'lastname' => 'Doe',
// ]
```

# Available attributes

| Name | Description |
| --- | --- |
| Hidden | Hides the attribute |
| HiddenIfNull | Hides the attribute when its value is null |
| StrToCarbon(?string $from_format, ?string $timezone) | Casts the attribute to a Carbon instance |

# Todo:
  - use spatie template ?
  - implement casts (i.e: strToCarbon(str, format, timezone))

