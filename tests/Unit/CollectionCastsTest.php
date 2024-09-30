<?php

namespace Jdefez\Tests\Unit;

use Illuminate\Support\Collection;
use Jdefez\Tests\Fixtures\Casts\ArrayToCollectionFixture;
use Jdefez\Tests\Fixtures\Casts\ArrayToCollectionOfDtoFixture;
use Jdefez\Tests\Fixtures\Casts\RoleDtoFixture;
use stdClass;

it('should cast array to collection', function () {
    $dto = ArrayToCollectionFixture::make([
        'users' => [1, 2, 3],
    ]);

    expect($dto->users)->toBeInstanceOf(Collection::class);
    expect($dto->users->toArray())->toBe([1, 2, 3]);
});

it('should cast empty array to collection', function () {
    $dto = ArrayToCollectionFixture::make([
        'users' => [],
    ]);

    expect($dto->users)->toBeInstanceOf(Collection::class);
    expect($dto->users->toArray())->toBe([]);
});

it('return null if value is not an array', function (mixed $value) {
    $dto = ArrayToCollectionFixture::make(['users' => $value]);

    expect($dto->users)->toBeNull();
})
    ->with([null, 'string', 1, 1.1, true, false, new stdClass]);

it('should cast to collection of RoleDto', function () {
    $dto = ArrayToCollectionOfDtoFixture::make([
        'roles' => [
            ['name' => 'admin'],
            ['name' => 'user'],
        ],
    ]);

    expect($dto->roles)->toBeInstanceOf(Collection::class);
    expect($dto->roles->every(fn ($item) => $item instanceof RoleDtoFixture))
        ->toBeTrue();
});
