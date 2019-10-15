<?php

namespace App\Enums;

abstract class TicketType extends Enum
{
    const DID = 'did';
    const SETTING = 'setting';
}

abstract class TicketStatus extends Enum
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
}
