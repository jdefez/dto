<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Dto\Exceptions\ValidationException;
use Jdefez\Tests\Fixtures\Validators\CustomValidatorFixture;

it('it can use custom validator', function () {
    $dto = CustomValidatorFixture::make([
        'start_at' => now()->addDay(),
        'end_at' => now()->subDay(),
    ]);
})->throws(ValidationException::class);
