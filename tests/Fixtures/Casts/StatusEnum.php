<?php

namespace Ayctor\Tests\Fixtures\Casts;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
