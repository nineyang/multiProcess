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
    public function __construct(Closure $closure , $num = 1)
    {
        $this->task = $closure;
        $this->num = $num;
    }
}