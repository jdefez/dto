<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Dtos\UserDto;
use Carbon\Carbon;

test('toArray returns an array', function () {
    $dto = UserDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'password' => '$password',
        'created_at' => '01/01/2021 00:00:00',
    ]);

    $result = $dto->toArray();

    expect($result['firstname'])->toBe($result['firstname']);
    expect($result['lastname'])->toBe($result['lastname']);
    expect($result['created_at'])->toBeInstanceOf(Carbon::class);

    // expect($dto)
    //     ->toArray()
    //     ->toEqualCanonicalizing([
    //         'firstname' => 'John',
    //         'lastname' => 'Doe',
    //     ]);
});
