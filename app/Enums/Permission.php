<?php

namespace App\Enums;

abstract class Permission extends Enum
{
    const CREATE_AGENT = 'create agent';
    const UPDATE_AGENT = 'update agent';
    const CREATE_USER = 'create user';
}
