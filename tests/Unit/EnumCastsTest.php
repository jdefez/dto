<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Fixtures\Casts\EnumFixture;
use Ayctor\Tests\Fixtures\Casts\StatusEnum;

it('casts to enum', function () {
    $dto = EnumFixture::make([
        'name' => 'John Doe',
        'status' => 'active',
    ]);

    expect($dto->status)->toBeInstanceOf(StatusEnum::class);
    expect($dto->name)->toBe('John Doe');
});
