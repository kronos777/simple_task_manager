<?php

require_once 'vendor/autoload.php';

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;


class FileLogger implements LoggerInterface
{
    public function log($level, $message, array $context = []): void
    {

        $tm = setlocale (LC_TIME, 'ru_RU.UTF-8', 'Rus');
        $dateFormatted = (new \DateTime(null, new DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s');
        //$dateFormatted->setTimezone(new DateTimeZone('Russian/Moscow'));

        $message = sprintf(
            '[%s] %s: %s%s',
            $dateFormatted,
            $level,
            $message,
            PHP_EOL // Line break
        );

        $path = dirname(__FILE__).".log";
        file_put_contents($path, $message, FILE_APPEND);

    }
	
	public function emergency($message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }
	
    public function critical($message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info($message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
	
}
