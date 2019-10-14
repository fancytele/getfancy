<?php

namespace App\Enums;

abstract class Enum
{
    public static $constCacheArray = [];

    public static function getConstants()
    {
        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    public static function getValue($name)
    {
        $constants = self::getConstants();

        return $constants[$name];
    }

    public static function getValues()
    {
        $constants = self::getConstants();
        $values = [];

        foreach ($constants as $key => $value) {
            array_push($values, $constants[$key]);
        }
        
        return $values;
    }
}
