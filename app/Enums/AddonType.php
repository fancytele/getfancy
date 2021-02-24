<?php

namespace App\Enums;

abstract class AddonType extends Enum
{
    const SUBSCRIPTION = 'subscription';
    const OTF = 'otf';
}

abstract class AddonCode
{
    const PROFESSIONAL_RECORDING = 'F01';
}
