<?php

use Somsip\Logger\Formatter\CallerInlineFormatter;

class ApiCallTest extends PHPUnit_Framework_TestCase
{
    public function testNew()
    {
        $formatter = new CallerInlineFormatter();

        $this->assertInstanceOf('Somsip\Logger\Formatter\CallerInlineFormatter', $formatter);
    }

    public function testFormatDefault()
    {
        $formatter = new CallerInlineFormatter();
        $mockRecord = [
            'message' => 'Test message',
            'channel' => 'phpunit',
            'datetime' => '2000-01-01 00:00:00',
            'level_name' => 'TEST',
            'context' => [],
            'extra' => [
                'class' => '\\Tests\Unit\\Class',
                'function' => 'test',
                'line' => '123',
                'file' => '/var/www/test.php'
            ]
        ];

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: Class::test() Test message', $result);

    }

    public function testFormatNoClass()
    {
        $formatter = new CallerInlineFormatter();
        $mockRecord = [
            'message' => 'Test message',
            'channel' => 'phpunit',
            'datetime' => '2000-01-01 00:00:00',
            'level_name' => 'TEST',
            'context' => [],
            'extra' => [
                'function' => 'test',
            ]
        ];

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: test() Test message', $result);

    }

    public function testFormatNoFunction()
    {
        $formatter = new CallerInlineFormatter();
        $mockRecord = [
            'message' => 'Test message',
            'channel' => 'phpunit',
            'datetime' => '2000-01-01 00:00:00',
            'level_name' => 'TEST',
            'context' => [],
            'extra' => [
                'class' => '\\Tests\Unit\\Class',
            ]
        ];

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: Class::{undefined}() Test message', $result);

    }
}
