<?php
/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午4:28
 */

spl_autoload_register(function ($class_name) {
    $parts = explode('\\', $class_name);
    array_shift($parts);
    $class = 'src/' . implode('/', $parts) . '.php';
    require_once $class;
});


$task1 = new \MultiProcess\Task\ClosureTask('task1', function () {
    echo 'test1';
});
$task2 = new \MultiProcess\Task\ClosureTask('task2', function () {
    echo 'task2';
});
$manager = new \MultiProcess\ProcessManager();

$manager
    ->addTask($task1)
    ->addTask($task2)
    ->run();