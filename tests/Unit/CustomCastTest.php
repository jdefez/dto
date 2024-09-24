<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Fixtures\Casts\CustomCastFixture;

it('it can use custom cast', function () {
    $dto = CustomCastFixture::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
    ]);

    expect($dto->fullname)->toBe('John Doe');
});
