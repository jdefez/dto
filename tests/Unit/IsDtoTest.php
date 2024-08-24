<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\TestDto;

test('toArray returns an array', function () {
    $dto = TestDto::make([
        'firstname' => 'John',
        'lastname' => 'Doe',
        'password' => '$password',
        // TODO: date testing ??
        // 'created_at' => '01/01/2021 10:30:00',
    ]);

    expect($dto)
        ->toArray()
        ->toEqualCanonicalizing([
            // TODO: date testing ??
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
});
