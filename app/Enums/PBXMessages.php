<?php

namespace App\Enums;

abstract class PBXMessageType extends Enum
{
    const BUSINESS = 'business';
    const DOWNTIME = 'downtime';
    const ONHOLD = 'onhold';
}
