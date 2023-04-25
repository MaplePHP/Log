<?php

namespace PHPFuse\Log\Handlers;

use PHPFuse\Http\Interfaces\StreamInterface;
use PHPFuse\Http\Stream;

class ErrorLogHandler extends AbstractHandler
{

    function __construct(?string $file = NULL) 
    {
        ini_set("log_errors", "1");
        if(!is_null($file)) ini_set("error_log", $file);
    }

    /**
     * Apache/server error log handler
     * @param  string $level
     * @param  string $message
     * @param  string $date
     * @return void
     */
    function handler(string $level, string $message, array $context, string $date): void 
    {
        $message = sprintf($message, json_encode($context));
        error_log("[{$level}] {$message}");
    }

}