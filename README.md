## How to use

```php
$task1 = new \MultiProcess\Task\ClosureTask('task1', function () {
    echo 'task1';
} , 2);
$task2 = new \MultiProcess\Task\ClosureTask('task2', function () {
    echo 'task2';
} , 5);
$manager = new \MultiProcess\ProcessManager();

$manager
    ->addTask($task1)
    ->addTask($task2)
    ->run();
```