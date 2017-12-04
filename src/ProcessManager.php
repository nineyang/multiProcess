<?php

namespace MultiProcess;

use MultiProcess\Task\TaskInterface;
use ArrayAccess;
use MultiProcess\Common\Shell;

/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午3:23
 */
class ProcessManager implements ArrayAccess
{
    public $tasks = [];

    public $runnings = [];

    public $killed = [];


    /**
     * @param TaskInterface $task
     * @return $this
     */
    public function addTask(TaskInterface $task)
    {
        array_push($this->tasks, $task);

        return $this;
    }

    /**
     * 直接停止一个进程
     * @param $pid
     * @return $this
     */
    public function stopProcess($pid)
    {
        $this->killed[$pid] = $this->runnings[$pid];
        unset($this->runnings[$pid]);
        return $this;
    }

    public function run()
    {
        foreach ($this->tasks as $task) {
            Shell::exec('');
        }
    }

    public function offsetExists($pid)
    {
        return isset($this->runnings[$pid]);
    }


    public function offsetGet($pid)
    {
        return $this->runnings[$pid];
    }


    public function offsetSet($pid, $value)
    {

    }

    public function offsetUnset($pid)
    {
        unset($this->runnings[$pid]);
    }
}