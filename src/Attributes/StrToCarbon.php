<?php

namespace Ayctor\Dto\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\IsCastContract;
use Carbon\Carbon;

#[Attribute(Attribute::TARGET_PARAMETER)]
class StrToCarbon implements IsCastContract
{
    public function __construct(
        public ?string $from_format = null,
        public ?string $timezone = null,
    ) {}

    public function format(mixed $input): ?Carbon
    {
        if (! $input) {
            return null;
        }

        $instance = $this->getInstance($input);

        if (! $instance) {
            return null;
        }

        if ($this->timezone !== null) {
            $instance->setTimezone($this->timezone);
        }

        return $instance;
    }

    private function getInstance(string $input): Carbon|false
    {
        if ($this->from_format) {
            return Carbon::createFromFormat($this->from_format, $input);
        }

        return Carbon::parse($input);
    }
}
