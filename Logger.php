<?php

namespace PHPFuse\Log;

use PHPFuse\Log\Handlers\AbstractHandler;
use PHPFuse\Log\InvalidArgumentException;
use PHPFuse\Log\AbstractLogger;
use PHPFuse\Log\LogLevel;

class Logger extends AbstractLogger
{
    protected const DATETIME_FORMAT = 'c';

    private $handler;
    private $dateTime;

    function __construct(AbstractHandler $handler, ?DateTimeInterface $dateTime = NULL) 
    {
        $this->handler = $handler;
        $this->dateTime = $dateTime;
    }

    /**
     * Log Value
     * @param  string $level
     * @param  string|\Stringable $message 
     * @param  array $context
     * @return void
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $level = strtoupper($level);
        if(!defined(LogLevel::class.'::'.$level)) throw new InvalidArgumentException("The log level \"{$level}\" does not exist.", 1);
        $this->handler->handler(strtoupper($level), $this->handler->interpolate($message, $context), $context, $this->getDate());
    }

    /**
     * Get formated date
     * @return string
     */
    protected function getDate(): string 
    {
        if(is_null($this->dateTime)) $this->dateTime = new \DateTime("now");
        return $this->dateTime->format(static::DATETIME_FORMAT);
    }
}
