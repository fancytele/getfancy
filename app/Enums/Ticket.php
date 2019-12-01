<?php

namespace App\Enums;

abstract class TicketStatus extends Enum
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
}

abstract class TicketCategory extends Enum
{
    const NEW_ACCOUNT = 'new_account';
    const CANCELLATION = 'cancellation';
    const UPDATE = 'update';
}
