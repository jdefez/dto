<?php

namespace Jdefez\Tests\Unit;

use Jdefez\Dto\Exceptions\ValidationException;
use Jdefez\Tests\Fixtures\Validators\IsNegativeFixture;
use Jdefez\Tests\Fixtures\Validators\IsPositiveFixture;

it('IsPositive throws a validation exception', function (int|string $value) {
    IsPositiveFixture::make(['number' => $value]);
})
    ->throws(ValidationException::class)
    ->with([-30, 'trente']);

it('IsPositive validates on positive values', function (int $value) {
    $dto = IsPositiveFixture::make(['number' => $value]);

    expect($dto->number)->toBe($value);
})
    ->with([30, 0]);

it('IsNegative throws a validation exceptions', function (int|string $value) {
    IsNegativeFixture::make(['number' => $value]);
})
    ->throws(ValidationException::class)
    ->with([30, 'trente']);

it('IsNegative validates on negative values', function (int $value) {
    $dto = IsNegativeFixture::make(['number' => $value]);

    expect($dto->number)->toBe($value);
})
    ->with([-30, 0]);
