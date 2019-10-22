<?php

namespace App\Enums;

abstract class PBXType extends Enum
{
    const PREDEFINED = 'predefined';
    const CUSTOM = 'custom';
}

abstract class PBXMessageType extends Enum
{
    const BUSINESS = 'business';
    const DOWNTIME = 'downtime';
    const ONHOLD = 'onhold';
}
