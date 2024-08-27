<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Dtos\UserDto;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test('toArray returns an array', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'manager' => [
            'firstname' => 'Jimmy',
            'lastname' => 'Pain',
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

    $result = $dto->toArray();

    expect($result['firstname'])->toBe($result['firstname']);
    expect($result['lastname'])->toBe($result['lastname']);
    expect($result['created_at'])->toBeInstanceOf(Carbon::class);
    expect($result['roles'])->toBeInstanceOf(Collection::class);
    expect($result['manager'])->toBeInstanceOf(UserDto::class);
});
