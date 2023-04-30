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
    private $level;
    private $message;
    private $context;

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
        $this->level = strtoupper($level);
        if(!defined(LogLevel::class.'::'.$this->level)) throw new InvalidArgumentException("The log level \"{$this->level}\" does not exist.", 1);

        $this->message = $message;
        $this->context = $context;
        $this->handler->handler($this->level, $this->handler->interpolate($this->message, $this->context), $this->context, $this->getDate());
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
