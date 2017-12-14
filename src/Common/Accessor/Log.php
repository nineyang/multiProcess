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
    public $params;


    /**
     * @param $method
     */
    protected function outputToFile($method)
    {
        $prefix = "[" . date(Config::get('log.content_format', self::CONTENT_FORMAT)) . "] " . Config::get('init
        .env') . '.' . $method . ':';

        $this->console($prefix);
    }

    /**
     * @return null|string
     */
    protected function parseParams()
    {
        if (is_array($this->params)) {
            return json_encode($this->params);
        } elseif (is_string($this->params)) {
            return $this->params;
        } else {
            return null;
        }
    }

    /**
     * @param string $prefix
     */
    protected function console($prefix = '')
    {
        $logFile = File::getLogFile();
        $params = $this->parseParams();

        file_put_contents($logFile, $prefix . $this->message . $params, FILE_APPEND);
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        list($this->message, $this->params) = $arguments;
        $this->outputToFile(strtoupper($name));
    }
}