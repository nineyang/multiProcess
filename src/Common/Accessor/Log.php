<?php
/**
 * User: Nine
 * Date: 2017/12/4
 * Time: 下午3:15
 */

namespace MultiProcess\Common\Accessor;

use MultiProcess\Common\Facades\File;
use MultiProcess\Common\Facades\Config;

/**
 * Class Log
 * @package MultiProcess\Common\Accessor
 */
class Log
{
    /**
     * 默认内容类型
     */
    const CONTENT_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $params = '';

    /**
     * @var
     */
    public $logFile = '';

    /**
     * @param $method
     */
    protected function outputToFile($method)
    {
        # 没有传log的话就使用默认的logFile
        $this->logFile || $this->logFile = File::getLogFile();

        $this->console($this->getPrefix($method), $this->logFile);
    }


    /**
     *
     */
    public function outputCli()
    {
        $prefix = $this->getPrefix('CONSOLE');
        $args = func_get_args();
        array_unshift($args , $prefix);

        echo implode(" " , $args) . PHP_EOL;
    }

    /**
     * @param $method
     * @return string
     */
    protected function getPrefix($method)
    {
        return "[" . date(Config::get('log.content_format', self::CONTENT_FORMAT)) . "] " . Config::get('init.env') . '.' . $method . ':';
    }

    /**
     * @return null|string
     */
    protected function parseParams()
    {
        if (is_array($this->params)) {
            return ' ' . json_encode($this->params);
        } elseif (is_string($this->params)) {
            return ' ' . $this->params;
        } else {
            return null;
        }
    }

    /**
     * @param string $prefix
     * @param string $logFile
     */
    protected function console($prefix = '', $logFile)
    {
        $params = $this->parseParams();

        file_put_contents($logFile, $prefix . $this->message . $params . PHP_EOL, FILE_APPEND);
    }

    /**
     * $name 可以是 DEBUG 或 INFO 或 ERROR 或自定义，由你自己决定
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        @list($this->message, $this->params, $this->logFile) = $arguments;
        $this->outputToFile(strtoupper($name));
    }
}