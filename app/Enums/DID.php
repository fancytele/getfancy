<?php

namespace App\Enums;

abstract class DIDOrderStatus extends Enum
{
    const Pending = "pending";
    const Completed = "completed";
    const Canceled = "canceled";
}

abstract class DIDNumberType extends Enum
{
    const Custom = "custom";
    const Fancy = "fancy";
}
