<?php

namespace Jdefez\Dto\Exceptions;

use InvalidArgumentException;

class MissingAttributeException extends InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
