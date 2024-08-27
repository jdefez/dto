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
    ) {}

    /**
     * @param  array<mixed>  $input
     * @return Collection<int, mixed>
     *
     * @throws InvalidArgumentException
     */
    public function format(mixed $input): ?Collection
    {
        if (! $input || ! is_array($input)) {
            return null;
        }

        if ($this->dto && $this->dtoIsValid()) {
            $input = array_map(
                fn ($item) => $this->dto::make($item),
                $input
            );
        }

        return new Collection($input);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function dtoIsValid(): bool
    {
        if (! $this->dto) {
            return true;
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
