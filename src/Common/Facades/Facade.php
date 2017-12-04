<?php
/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午5:16
 */

namespace MultiProcess\Common\Facades;

/**
 * 参考Laravel的Facade
 * Class Facade
 * @package MultiProcess\Common
 */
abstract class Facade
{
    /**
     * 存取器的命名空间
     */
    const ACCESSOR_NAMESPACE = 'MultiProcess\Common\Accessor\\';

    /**
     * @var array
     */
    public static $facades = [];

    /**
     * 获取当前执行的Facade
     * @return mixed
     */
    public static function getAccessorObject()
    {
        if (method_exists(static::class, 'getFacadeAccessor')) {
            $class = static::getFacadeAccessor();
        } else {
            $parts = explode('\\', self::class);

            $class = array_pop($parts);
        }

        $class = self::ACCESSOR_NAMESPACE . ucfirst($class);
        if (!isset(self::$facades[$class])) {
            self::$facades[$class] = new $class;
        }

        return self::$facades[$class];
    }

    /**
     * @param $method
     * @param array ...$args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return self::getAccessorObject()->$method(...$args);
    }
}