<?php

namespace App\Enums;

abstract class DIDOrderStatus extends Enum
{
    const PENDING = "pending";
    const COMPLETED = "completed";
    const CANCELED = "canceled";
}

abstract class DIDNumberType extends Enum
{
    const CUSTOM = "custom";
    const FANCY = "fancy";
}
