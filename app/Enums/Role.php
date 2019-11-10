<?php

namespace App\Enums;

abstract class Role extends Enum
{
    const ADMIN = 'admin';
    const AGENT = 'agent';
    const USER = 'user';
}
