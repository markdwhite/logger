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
            $append = sprintf('%s::', $class);
        } else {
            $append = '';
        }
        if ($function = $this->extractFunction($record['extra'])) {
            $append = sprintf('%s%s()', $append, $function);
        }
        if (!empty($append)) {
            $record['message'] = sprintf('%s %s', $append, $record['message']);
        }

        return parent::format($record);
    }

    /**
     * Extracts the calling class from the record
     *
     * @param array $record
     * @return string
     */
    private function extractClass(array $record)
    {
        if (isset($record['class'])) {
            $class = $record['class'];
            // Strip the namespace
            $backslashPos = strrpos($class, '\\');
            if ($backslashPos !== false) {
                $class = substr($class, $backslashPos + 1);
            }
            return $class;
        }
        return false;
    }

    /**
     * Extracts the calling function
     *
     * @param array $record
     * @return string
     */
    private function extractFunction(array $record)
    {
        if (isset($record['function'])) {
            return $record['function'];
        }
        return false;
    }
}
