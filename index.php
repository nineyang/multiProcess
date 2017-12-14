<?php
/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午4:28
 */

require_once 'src/ProcessManager.php';
require_once 'src/Task/ClosureTask.php';

$task = new \MultiProcess\Task\ClosureTask('test1', function () {
    echo 'hello world';
});

$manager = new \MultiProcess\ProcessManager();

$manager->addTask($task);

$manager->run();