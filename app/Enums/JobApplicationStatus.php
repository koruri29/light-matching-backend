<?php

namespace App\Enums;

enum JobApplicationStatus: string
{
    case APPLIED = 'applied';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
