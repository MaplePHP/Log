<?php

namespace PHPFuse\Log\Interfaces;

interface HandlerInterface
{
    
    function handler(string $level, string $message, array $context, string $date): void;
   
}