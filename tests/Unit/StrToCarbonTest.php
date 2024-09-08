<?php

namespace Ayctor\Tests\Unit;

use Ayctor\Tests\Fixtures\Casts\StrToCarbonFixture;
use Carbon\Carbon;

it('cast to carbon', function () {
    $dto = StrToCarbonFixture::make(['date' => '01/01/2021']);

    expect($dto->date)->toBeInstanceOf(Carbon::class);
    expect($dto->date->format('Y-m-d'))->toBe('2021-01-01');
});
