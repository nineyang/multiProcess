## 说明
一个简单方便的`PHP`多进程管理工具。
其中`Log`，`Config`等部分的实现借鉴了`Laravel`的`Facades`写法。

## 快速上手

```
composer require nine/multi-process 
```

```php
$task1 = new \MultiProcess\Task\ClosureTask('task1', function () {
    # do your task
} , 2);
$task2 = new \MultiProcess\Task\ClosureTask('task2', function () {
    # do your task
} , 5);
$manager = new \MultiProcess\ProcessManager();

$manager
    ->addTask($task1)
    ->addTask($task2)
    ->run();
```