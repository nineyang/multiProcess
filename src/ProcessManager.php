<?php

namespace MultiProcess;

use MultiProcess\Task\TaskInterface;
use MultiProcess\Common\Facades\Shell;

/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午3:23
 */
class ProcessManager
{
    /**
     * @var array
     */
    public $tasks = [];

    /**
     * @var array
     */
    public $runnings = [];

    /**
     * @var array
     */
    public $killed = [];

    /**
     * @var int
     */
    private $_sleep = 1000;

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

    /**
     * 开始任务
     */
    public function run()
    {
        foreach ($this->tasks as $task) {
            $this->tasks[$task->name] = $task->handler();
            usleep($this->_sleep);
        }
    }
}