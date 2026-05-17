<?php

namespace App\Enums;

enum HarvestPoolStatus: string
{
    case Open = 'open';
    case Fulfilled = 'fulfilled';
    case Expired = 'expired';
}
