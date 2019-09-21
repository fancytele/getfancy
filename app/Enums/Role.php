<?php

namespace App\Enums;

abstract class Role extends Enum
{
    const Admin = 'admin';
    const Agent = 'agent';
    const User = 'user';
}
