<?php

$laoder = require dirname(__DIR__) . '/vendor/autoload.php';

class TestHelper
{
    public static function invokePrivateMethod($class, $methodName, $args)
    {
        $method = new \ReflectionMethod($class, $methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($class, $args);
    }

    public static function getPrivateProperty($class, $propName)
    {
        $reflectionClass = new \ReflectionClass(get_class($class));
        $prop = $reflectionClass->getProperty($propName);
        $prop->setAccessible(true);

        return $prop->getValue($class);
    }

    public static function setPrivateProperty($class, $propName, $value)
    {
        $reflectionClass = new \ReflectionClass(get_class($class));
        $prop = $reflectionClass->getProperty($propName);
        $prop->setAccessible(true);
        $prop->setValue($class, $value);
    }
}
