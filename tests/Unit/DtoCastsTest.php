<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Tests\Fixtures\Casts\RoleDtoFixture;
use Jdefez\Tests\Fixtures\Casts\ToDtoFixture;

it('casts to dto', function () {
    $dto = ToDtoFixture::make([
        'name' => 'John Doe',
        'role' => [
            'name' => 'Admin',
        ],
    ]);

    expect($dto->role)->toBeInstanceOf(RoleDtoFixture::class);
    expect($dto->name)->toBe('John Doe');
});

it('casts to dto from an object', function () {
    $dto = ToDtoFixture::make((object) [
        'name' => 'John Doe',
        'role' => (object) [
            'name' => 'Admin',
        ],
    ]);

    expect($dto->role)->toBeInstanceOf(RoleDtoFixture::class);
    expect($dto->name)->toBe('John Doe');
});

it('returns default value if value is not an array or an object', function ($value) {
    $dto = ToDtoFixture::make([
        'name' => 'John Doe',
        'role' => $value,
    ]);

    expect($dto->name)->toBe('John Doe');
    expect($dto->role)->toBeNull();
})
    ->with(['string', 1, 1.1, true, false]);
