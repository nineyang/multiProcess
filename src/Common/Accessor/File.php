<?php
/**
 * User: Nine
 * Date: 2017/12/4
 * Time: 下午3:14
 */

namespace MultiProcess\Common\Accessor;

use MultiProcess\Common\Facades\Config;


class File
{

    /**
     * 默认生成的log文件名类型
     */
    const FILENAME_FORMAT = 'Y-m-d';

    /**
     * 读写权限
     */
    const READ_ADN_WRITE = 0755;

    /**
     * @param string $ext
     * @return string
     */
    public function getLogFile($ext = '.log')
    {
        $file = Config::get('log.base_path') . '/' . date(Config::get('log.filename_format', self::FILENAME_FORMAT)) . $ext;

        if (!file_exists($file)) {
            return $this->makeFile($file);
        } elseif (!is_writable($file)) {
            chmod($file, self::READ_ADN_WRITE);
        }

        return $file;
    }

    /**
     * @param $file
     * @return string
     */
    public function makeFile($file)
    {
        $fileHandler = fopen($file, 'w+');

        fclose($fileHandler);

        return $file;
    }
}