<?php

namespace MultiProcess\Common\Facades;

/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午5:17
 */
class Log extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'log';
    }
}