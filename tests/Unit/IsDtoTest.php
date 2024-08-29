<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Samples\RoleDto;
use Ayctor\Tests\Samples\UserDto;
use Ayctor\Tests\Samples\UserStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test('toArray returns an array', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'status' => 'active',
        'manager' => [
            'firstname' => 'Jimmy',
            'lastname' => 'Pain',
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

    expect($dto->firstname)->toBe('John');
    expect($dto->lastname)->toBe('Doe');
    expect($dto->password)->toBe('$password');

    // NOTE: casted properties
    
    expect($dto->created_at)->toBeInstanceOf(Carbon::class);
    expect($dto->roles)->toBeInstanceOf(Collection::class);
    expect($dto->roles->first())->toBeInstanceOf(RoleDto::class);
    expect($dto->manager)->toBeInstanceOf(UserDto::class);
    expect($dto->status)->toBeInstanceOf(UserStatus::class);

    expect($dto->toArray())->toBeArray();

    // NOTE: hidden properties
    
    expect($dto->toArray())->not()->toHaveKey('password');
    expect($dto->toArray())->not()->toHaveKey('id');
});
