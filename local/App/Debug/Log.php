<?php
namespace App\Debug;

use Bitrix\Main\Diag\ExceptionHandlerFormatter;
use Bitrix\Main\Diag\FileExceptionHandlerLog;

class Log extends FileExceptionHandlerLog
{
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
    public function write($exception, $logType)
    {
        $text = ExceptionHandlerFormatter::format($exception, false, $this->logLevel);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = "{date} - Host: {host} - {type} - {$text}\n";

        $this->logger->log($logLevel, $message, $context);
    }
}