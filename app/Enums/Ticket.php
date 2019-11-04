<?php

namespace App\Enums;

abstract class TicketStatus extends Enum
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const REMOVED = 'removed';
}
