<?php

namespace MaplePHP\Log\Handlers;

use MaplePHP\Http\Interfaces\StreamInterface;
use MaplePHP\Http\Stream;

class ErrorLogHandler extends AbstractHandler
{
    public function __construct(?string $file = null)
    {
        ini_set("log_errors", "1");
        if (!is_null($file)) {
            ini_set("error_log", $file);
        }
    }

    /**
     * Apache/server error log handler
     * @param  string $level
     * @param  string $message
     * @param  string $date
     * @return void
     */
    public function handler(string $level, string $message, array $context, string $date): void
    {
        $message = sprintf($message, json_encode($context));
        error_log("[{$level}] {$message}");
    }
}
