<?php

namespace App\Library;
 
use Illuminate\Support\Facades\DB;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
 
class Logs
{
 
    /**
     * 写入告警日志
     *
     * @param $message
     * @param array $data
     * @param string $type
     */
    public static function warning($message, $data = [], $type = 'warning', $isDate = true)
    {
        self::_save($message, $data, $type, $isDate);
    }

    /**
     * 输出日志信息
     *
     * @param $message
     * @param array $data
     * @param string $type
     */
    public static function info($message, $data = [], $type = 'info', $isDate = true)
    {
        self::_save($message, $data, $type, $isDate);
    }
    
    /**
     * 写入debug日志
     *
     * @param $message
     * @param array $data
     * @param string $type
     */
    public static function debug($message, $data = [], $type = 'debug', $isDate = true)
    {
        self::_save($message, $data, $type, $isDate);
    }

    /**
     * 写入错误日志
     *
     * @param $message
     * @param array $data
     * @param string $type
     */
    public static function error($message, $data = [], $type = 'error', $isDate = true)
    {
        self::_save($message, $data, $type, false);
    }
 
    /**
     * 保存日志文件
     *
     * @param $message
     * @param array $data
     * @param string $type
     * @param string $isDate 是否按月份分文件夹
     */
    private static function _save($message, $data = [], $type = 'log', $isDate = true)
    {
        try {
            $log = new Logger('okrlog');
            if (PHP_SAPI == 'cli') {
                $fileName = $type.'_cli';
            }
     
            $fileName = $type . '.log';
     
            if ($isDate) {
                $path = storage_path('logs/' . date('Ym'));
            } else {
                $path = storage_path('logs/');
            }
            self::mkDirs($path);
     
            $path = $path . '/' . $fileName;
            if (gettype($data) != 'array') {
                $message .= "：" . $data;
                $data = [];
            }
     
            $log->pushHandler(new StreamHandler($path, Logger::INFO));
            $log->$type($message, $data);
        } catch (Exception $e) {
            self::info("日志记录错误:".$e->getMessage()); 
        }

    }
    
    /**
     * 给日志文件夹权限
     *
     * @param $dir
     * @param int $mode
     * @return bool
     */
    public static function mkDirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) {
            return true;
        }
        if (!self::mkdirs(dirname($dir), $mode)) {
            return false;
        }
        return @mkdir($dir, $mode);
    }
    
    /**
     * 记录laravel sql执行
     *
     * @param string $fileName
     * @param bool $isDate
     */
    public static function sql($fileName = 'sql', $isDate = true)
    {
        DB::listen(function ($sql) use ($fileName, $isDate) {
            foreach ($sql->bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $sql->bindings[$i] = "'$binding'";
                    }
                }
            }
            $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
            $query = vsprintf($query, $sql->bindings);
            Logs::info('sql:', $query, $file_name, $is_date);
        });
    }
}
