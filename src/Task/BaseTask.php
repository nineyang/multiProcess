<?php

/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午3:19
 */

namespace MultiProcess\Task;
use Closure;

/**
 * Class BaseTask
 * @package MultiProcess\Task
 */
class BaseTask implements TaskInterface
{
    /**
     * 进程id
     * @var
     */
    public $pid;

    /**
     * 启动脚本数量
     * @var
     */
    public $num;

    /**
     * 创建的任务
     * @var
     */
    public $task;

    /**
     * 调度task
     */
    public function handler()
    {
        $parts = explode('\\', static::class);
        $method = 'handler' . array_pop($parts);

        ## todo 这里要根据设置的num来发起需要开启的进程数量
        if (method_exists(self::class, $method)) {
            return $this->$method();
        }

        return null;
    }

    public function handlerClosure()
    {
        if ($this->task instanceof Closure) {
            $this->task();
        }
    }


}