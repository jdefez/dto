<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Dto\Exceptions\ValidationException;
use Ayctor\Tests\Samples\RoleDto;
use Ayctor\Tests\Samples\UserDto;
use Ayctor\Tests\Samples\UserStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;

it('hides properties', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'status' => 'active',
        'created_at' => '01/01/2021 00:00:00',
        'age' => 30,
    ]);

    // NOTE: hidden properties

    expect($dto->toArray())
        ->not()->toHaveKey('password')
        ->not()->toHaveKey('status')
        ->not()->toHaveKey('id');
});

it('casts properties', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'status' => 'active',
        'age' => 30,
        'manager' => [
            'firstname' => 'Jimmy',
            'lastname' => 'Pain',
            'age' => 25,
            'status' => 'inactive',
            'password' => 'jp$password',
            'created_at' => '02/01/2021 00:00:00',
            'roles' => [
                ['name' => 'manager', 'id' => 3],
            ],
        ],
        'password' => '$password',
        'created_at' => '01/01/2021 00:00:00',
        'roles' => [
            ['name' => 'admin', 'id' => 1],
            ['name' => 'user', 'id' => 2],
        ],
    ]);


    expect($dto)
        ->firstname->toBe('John')
        ->lastname->toBe('Doe')
        ->age->toBe(30)
        ->password->toBe('$password');

    // NOTE: casted properties

    expect($dto)
        ->created_at->toBeInstanceOf(Carbon::class)
        ->roles->toBeInstanceOf(Collection::class)
        ->roles?->first()->toBeInstanceOf(RoleDto::class)
        ->manager->toBeInstanceOf(UserDto::class)
        ->status->toBeInstanceOf(UserStatus::class);
});

it('throws a validation exception with IsPositive validator', function () {
    UserDto::make([
        'created_at' => '01/01/2021 00:00:00',
        'firstname' => 'John',
        'lastname' => 'Doe',
        'status' => 'active',
        'age' => -30,
    ]);
})
    ->throws(
        ValidationException::class,
        "The attribute age must be positive '-30' given."
    );

it('returns an array when toArray is called', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'status' => 'active',
        'age' => 30,
        'manager' => [
            'firstname' => 'Jimmy',
            'lastname' => 'Pain',
            'age' => 25,
            'status' => 'inactive',
            'password' => 'jp$password',
            'created_at' => '02/01/2021 00:00:00',
            'roles' => [
                ['name' => 'manager', 'id' => 3],
            ],
        ],
        'password' => '$password',
        'created_at' => '01/01/2021 00:00:00',
        'roles' => [
            ['name' => 'admin', 'id' => 1],
            ['name' => 'user', 'id' => 2],
        ],
    ]);

    expect($dto->toArray())->toBeArray();
});
