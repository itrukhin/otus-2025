<?php
namespace App\Debug;

use Bitrix\Main\Diag\Debug;

class Log
{
    /**
     * @param $message
     * @param bool $clear
     * @param string $fileName
     * @return void
     */
    public static function addLog($message, bool $clear = false, string $fileName = 'custom'): void
    {
        if($clear) {
            self::cleanLog($fileName);
        }
        Debug::writeToFile(
            $message,
            '',
            'local/logs/log_' . $fileName . '.log'
        );
    }

    /**
     * @param string $fileName
     * @return void
     */
    public static function cleanLog(string $fileName = 'custom'): void
    {
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/local/logs/log_' . $fileName . '.log', '');
    }
}