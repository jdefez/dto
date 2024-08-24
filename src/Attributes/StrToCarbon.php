<?php

namespace Ayctor\Dto\Attributes;

use Attribute;
use Carbon\Carbon;

#[Attribute(Attribute::TARGET_PROPERTY)]
class StrToCarbon implements IsCastContract
{
    public function __construct(
        public ?string $from_format = null,
        public ?string $timezone = null,
    ) {}

    public function format(?string $input): ?Carbon
    {
        if (! $input) {
            return null;
        }

        if ($this->from_format !== null) {
            $instance = Carbon::createFromFormat($this->from_format, $input);
        } else {
            $instance = Carbon::parse($input);
        }

        if ($this->timezone !== null) {
            $instance->setTimezone($this->timezone);
        }

        return $instance;
    }
}
