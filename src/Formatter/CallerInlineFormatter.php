<?php

namespace Somsip\Logger\Formatter;

use Monolog\Formatter\LineFormatter;

/**
 * Formats incoming records into a one-line string prefixed by the calling Class::function()
 *
 * @author Mark White <mark@somsip.com>
 */
class CallerInlineFormatter extends LineFormatter
{
    const SIMPLE_FORMAT = "[%datetime%] %channel%.%level_name%: %message%\n";

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        // Append class and function to the message
        if ($class = $this->extractClass($record['extra'])) {
            $class .= "::";
        }
        if (!$function = $this->extractFunction($record['extra'])) {
            $function = '{undefined}';
        }
        $record['message'] = sprintf('%s%s() %s', $class, $function, $record['message']);

        return parent::format($record);
    }

    /**
     * Extracts the calling class from the extras
     *
     * @param array $extra
     * @return string
     */
    private function extractClass(array $extra)
    {
        if (!isset($extra['class'])) {
            return '';
        }

        $class = $extra['class'];
        // Strip the namespace
        $backslashPos = strrpos($class, '\\');
        if ($backslashPos !== false) {
            $class = substr($class, $backslashPos + 1);
        }
        return $class;
    }

    /**
     * Extracts the calling function from the extras
     *
     * @param array $extra
     * @return string
     */
    private function extractFunction(array $extra)
    {
        if (!isset($extra['function'])) {
            return '';
        }
        return $extra['function'];
    }
}
