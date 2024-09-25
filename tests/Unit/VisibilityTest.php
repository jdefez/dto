<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Tests\Fixtures\Visibility\HiddenFixture;
use Jdefez\Tests\Fixtures\Visibility\HiddenIfNullFixture;

it('Hidden always hides property', function () {
    $dto = HiddenFixture::make([
        'firstname' => 'John',
        'id' => 1,
    ]);

    // NOTE: hidden properties

    expect($dto->toArray())
        ->toHaveKey('firstname')
        ->not()->toHaveKey('id');
});

it('HiddenIfNull hides property when its value is null', function () {
    $dto = HiddenIfNullFixture::make([
        'firstname' => 'John',
        'id' => null,
    ]);

    // NOTE: hidden properties

    expect($dto->toArray())
        ->toHaveKey('firstname')
        ->not()->toHaveKey('id');
});

it('HiddenIfNull does not hide property when its value is not null', function () {
    $dto = HiddenIfNullFixture::make([
        'firstname' => 'John',
        'id' => 12,
    ]);

    // NOTE: hidden properties

    expect($dto->toArray())
        ->toHaveKey('firstname')
        ->toHaveKey('id');
});
