<?php

/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午3:19
 */

namespace MultiProcess\Task;

use Closure;
use Exception;
use MultiProcess\Common\Facades\Config;
use MultiProcess\Common\Facades\Log;

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
     * 任务名称
     * @var
     */
    public $name;

    /**
     * @var array
     */
    private $_command = [];

    /**
     * BaseTask constructor.
     * @param $name
     * @param int $num
     */
    public function __construct($name, $num)
    {
        $this->name = $name;
        $this->num = $num;
        $this->initCommand();
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set($name, $value)
    {
        $this->$name = $value;

        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * 调度task
     */
    public function handler()
    {
        throw new Exception("Not found method:handler in class:" . static::class);
    }

    /**
     * @return string
     */
    public function getPHPBindir()
    {
        return PHP_BINDIR . '/php';
    }

    /**
     * @param $command
     * @return $this
     */
    public function addCommand($command)
    {
        array_push($this->_command, $command);
        return $this;
    }

    /**
     * 初始化command
     */
    private function initCommand()
    {
        $this
            ->addCommand($this->getPHPBindir())
            ->addCommand(Config::get('init.worker'));
    }

    /**
     * @return mixed
     */
    public function exec()
    {
        foreach (range(1, $this->num) as $number) {
            switch ($pid = pcntl_fork()) {
                case -1:
                    die('Fork failed');
                    break;
                case 0:
                    Log::info(posix_getpid() . " start work", ['task_name' => $this->name]);
                    Log::outputCli(
                        posix_getpid(),
                        "start work",
                        "task name:{$this->name}"
                    );
                    ($this->task)();
                    Log::info(posix_getpid() . " end");
                    break;
                default:
                    $res = pcntl_waitpid($pid, $status, WNOHANG);
                    exit();
                    break;
            }
        }
    }
}