<?php
/**
 * User: Nine
 * Date: 2017/12/4
 * Time: 下午2:27
 */

namespace MultiProcess\Common\Facades;

class Config extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'config';
    }
}