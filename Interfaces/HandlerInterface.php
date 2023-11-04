<?php

namespace PHPFuse\Log\Interfaces;

interface HandlerInterface
{
    public function handler(string $level, string $message, array $context, string $date): void;
}
