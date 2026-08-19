<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';

    case Started = 'started';

    case Completed = 'completed';

    case Expired = 'expired';

    case Cancelled = 'cancelled';
}