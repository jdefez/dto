<?php

namespace Ayctor\Dto\Attributes;

use Attribute;
use Ayctor\Dto\Contracts\DtoContract;
use Ayctor\Dto\Contracts\IsCastContract;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use ReflectionClass;

#[Attribute(Attribute::TARGET_PARAMETER)]
class ArrayToCollection implements IsCastContract
{
    /**
     * @param  ?class-string  $dto
     */
    public function __construct(
        public ?string $dto = null,
        public mixed $default = null,
    ) {}

    /**
     * @return ?Collection<int, mixed>
     *
     * @throws InvalidArgumentException
     */
    public function format(mixed $input): ?Collection
    {
        if (! $input || ! is_array($input)) {
            return $this->default;
        }

        if (! $this->dto) {
            return new Collection($input);
        }

        if ($this->dtoIsValid()) {
            // @phpstan-ignore-next-line
            return (new Collection($input))->map(
                fn ($item) => $this->dto::make($item),
            );
        }

        return $this->default;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function dtoIsValid(): bool
    {
        if (! $this->dto) {
            return false;
        }

        $ref = new ReflectionClass($this->dto);
        if (! $ref->implementsInterface(DtoContract::class)) {
            throw new InvalidArgumentException(
                "The dto {$this->dto} must implement DtoContract"
            );
        }

        return true;
    }
}
