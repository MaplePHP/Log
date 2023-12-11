<?php

namespace MaplePHP\Log\Handlers;

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
     * Take over the servers error log handler
     * @param  string $level
     * @param  string $message
     * @param  array  $context
     * @param  string $date (Only a placeholder right now, date is handled automatically by error_log)
     * @return void
     */
    public function handler(string $level, string $message, array $context, string $date): void
    {
        $encode = json_encode($context);
        $message = sprintf($message, $encode);
        error_log("[{$level}] {$message} {$encode}");
    }
}
