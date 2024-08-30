<?php

namespace Ayctor\Dto\Exceptions;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}