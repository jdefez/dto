<?php

use Ayctor\Tests\TestDto;

test('toArray return an array', function () {
    $dto = TestDto::make([
        // 'id' => 1,
        'name' => 'John Doe'
    ]);
    expect($dto)
        ->toArray()
        // ->dump()
        ->toEqualCanonicalizing([
            'name' => 'John Doe',
        ]);
});
