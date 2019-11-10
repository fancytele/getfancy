<?php

namespace App\Enums;

abstract class AddonType extends Enum
{
    const SUBSCRIPTION = 1;
    const OTF = 2;
}

abstract class AddonCode
{
    const PROFESSIONAL_RECORDING = 'F01';
}
