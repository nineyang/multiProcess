<?php
/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午4:02
 */

namespace MultiProcess\Task;

use Closure;

/**
 * 闭包任务
 * Class ClosureTask
 * @package MultiProcess\Task
 */
class ClosureTask extends BaseTask
{

    /**
     * ClosureTask constructor.
     * @param $name
     * @param Closure $closure
     * @param int $num
     */
    public function __construct($name, Closure $closure, $num = 1)
    {
        $this->task = $closure;
        parent::__construct($name , $num);
    }

    /**
     *
     */
    public function handler()
    {
        $this->addCommand(serialize($this->task))
            ->exec();
    }
}