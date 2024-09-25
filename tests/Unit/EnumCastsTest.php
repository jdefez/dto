<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Tests\Fixtures\Casts\EnumFixture;
use Jdefez\Tests\Fixtures\Casts\StatusEnum;

it('casts to enum', function () {
    $dto = EnumFixture::make([
        'name' => 'John Doe',
        'status' => 'active',
    ]);

    expect($dto->status)->toBeInstanceOf(StatusEnum::class);
    expect($dto->name)->toBe('John Doe');
});
