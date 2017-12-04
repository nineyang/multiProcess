<?php
/**
 * User: Nine
 * Date: 2017/12/1
 * Time: 下午6:05
 */

namespace MultiProcess\Common\Accessor;

/**
 * Class Config
 * @package MultiProcess\Common
 */
class Config
{
    /**
     * 配置的默认目录
     */
    const CONFIG_PATH = __DIR__ . '/../../../config/';

    /**
     * @var array
     */
    public $config = [];

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        $parts = explode('.', $key);
        $file = $parts[0];
        if (isset($this->config[$file])) {
            return $this->output($parts);
        }
        if (!file_exists(self::CONFIG_PATH . $file . '.php')) {
            return $default;
        }

        $this->config[$file] = require_once self::CONFIG_PATH . $file . '.php';

        return $this->output($parts);

    }

    /**
     * @param array $parts
     * @param null $default
     * @return null|string
     */
    private function output(array $parts, $default = null)
    {
        if (count($parts) == 1) {
            return $this->config[$parts[0]];
        }
        $config = $this->config[array_shift($parts)];

        while (isset($config[current($parts)])) {
            $default = $config[current($parts)];
            if (is_array($default)) {
                $config = $default;
            }
            next($parts);
        }

        return $default;
    }

    private function input()
    {

    }
}
