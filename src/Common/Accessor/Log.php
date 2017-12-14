<?php
/**
 * User: Nine
 * Date: 2017/12/4
 * Time: 下午3:15
 */

namespace MultiProcess\Common\Accessor;

/**
 * Class Log
 * @package MultiProcess\Common\Accessor
 */
class Log
{

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $params;


    protected function outputToFile($method)
    {

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