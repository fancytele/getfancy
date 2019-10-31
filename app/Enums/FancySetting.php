<?php

namespace App\Enums;

abstract class FancyNotificationPeriod extends Enum
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
}

abstract class FancyAudioType extends Enum
{
    const PREDEFINED = 'predefined';
    const CUSTOM = 'custom';
    const PROFESSIONAL = 'professional';
}
