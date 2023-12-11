<?php

namespace MaplePHP\Log;

use MaplePHP\Log\Handlers\AbstractHandler;
use MaplePHP\Log\InvalidArgumentException;
use MaplePHP\Log\AbstractLogger;
use MaplePHP\Log\LogLevel;
use DateTimeInterface;

class Logger extends AbstractLogger
{
    protected const DATETIME_FORMAT = 'c';

    private $handler;
    private $dateTime;
    private $level;
    private $message = "";
    private $context;

    public function __construct(AbstractHandler $handler, ?DateTimeInterface $dateTime = null)
    {
        $this->handler = $handler;
        $this->dateTime = $dateTime;
    }

    /**
     * Log Value
     * @param  mixed $level
     * @param  string|\Stringable $message
     * @param  array $context
     * @return void
     */
    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $this->level = strtoupper($level);
        if (!defined(LogLevel::class . '::' . $this->level)) {
            throw new InvalidArgumentException("The log level \"{$this->level}\" does not exist.", 1);
        }

        $this->message = $message;
        $this->context = $context;
        $this->handler->handler(
            $this->level,
            $this->handler->interpolate((string)$this->message, $this->context),
            $this->context,
            $this->getDate()
        );
    }

    public function getLevel(): mixed
    {
        return $this->level;
    }

    public function getMessage(): string
    {
        return (string)$this->message;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get formated date
     * @return string
     */
    protected function getDate(): string
    {
        if (is_null($this->dateTime)) {
            $this->dateTime = new \DateTime("now");
        }
        return $this->dateTime->format(static::DATETIME_FORMAT);
    }
}
