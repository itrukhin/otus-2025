<?php
namespace App\Debug;

use Bitrix\Main\Diag\ExceptionHandlerFormatter;
use Bitrix\Main\Diag\FileExceptionHandlerLog;

class Log extends FileExceptionHandlerLog
{
    /**
     * в родительском классе $level имеет приватный доступ
     * @var int $logLevel
     */
    private $logLevel;

    /**
     * @param array $options
     * @return void
     */
    public function initialize(array $options): void
    {
        parent::initialize($options);

        if (isset($options["level"]) && $options["level"] > 0)
        {
            $this->logLevel = (int)$options["level"];
        }
    }

    /**
     * @param \Throwable $exception
     * @param int $logType
     */
    public function write($exception, $logType): void
    {
        $text = ExceptionHandlerFormatter::format($exception, false, $this->logLevel);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = "OTUS: {date} - Host: {host} - {type} - {$text}\n";

        $this->logger->log($logLevel, $message, $context);
    }

    public function test()
    {
        dump($_SERVER);
    }
}