<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Dto\Exceptions\MissingAttributeException;
use Jdefez\Tests\Fixtures\Exceptions\MissingAttributeExceptionFixture;

it('throws an exception when an input attribute is missing', function () {
    $dto = MissingAttributeExceptionFixture::make([
        'firstname' => 'John',
        // 'lastname' => 'Doe',
    ]);
})->throws(MissingAttributeException::class, 'Missing attribute lastname.');
