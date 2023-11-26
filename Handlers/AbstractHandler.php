<?php

namespace MaplePHP\Log\Handlers;

use MaplePHP\Log\Interfaces\HandlerInterface;

/**
 * This is a simple Logger implementation that other Loggers can inherit from.
 *
 * It simply delegates all log-level-specific methods to the `log` method to
 * reduce boilerplate code that a simple Logger that does the same thing with
 * messages regardless of the error level has to implement.
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * Interpolates context values into the message placeholders.
     * @param  string $message
     * @param  array  $context
     * @return string
     */
    public function interpolate(string $message, array $context = array()): string
    {
        $replace = array();
        foreach ($context as $key => $val) {
            if (is_array($val)) {
                $replace['{' . $key . '}'] = json_encode($val);
            } elseif ((!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }
}
