<?php

namespace App\Enums;

enum UserRoles: string
{
    case CLIENT = 'client';
    case WORKER = 'worker';
}
