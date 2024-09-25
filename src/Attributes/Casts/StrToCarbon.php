<?php

namespace Jdefez\Dto\Attributes\Casts;

use Attribute;
use Jdefez\Dto\Contracts\IsCastContract;
use Carbon\Carbon;

#[Attribute(Attribute::TARGET_PARAMETER)]
class StrToCarbon implements IsCastContract
{
    public function __construct(
        public ?string $from_format = null,
        public ?string $timezone = null,
        public mixed $default = null,
    ) {}

    /**
     * @param  object|array<array-key, mixed>  $attributes
     */
    public function format(mixed $input, object|array $attributes): ?Carbon
    {
        if (! $input) {
            return $this->default;
        }

        $instance = $this->getInstance($input);

        if (! $instance) {
            return $this->default;
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
