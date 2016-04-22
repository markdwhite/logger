<?php

use Somsip\Logger\Formatter\CallerInlineFormatter;

class CallerInlineFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testNew()
    {
        $formatter = new CallerInlineFormatter();

        $this->assertInstanceOf('Somsip\Logger\Formatter\CallerInlineFormatter', $formatter);
    }

    public function testFormatDefault()
    {
        $formatter = new CallerInlineFormatter();
        $extra = [
                'class' => '\\Tests\Unit\\Class',
                'function' => 'test',
                'line' => '123',
                'file' => '/var/www/test.php'
        ];
        $mockRecord = $this->mockRecord($extra);


        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: Class::test() Test message', $result);
    }

    public function testFormatNoClass()
    {
        $formatter = new CallerInlineFormatter();
        $extra = [
                'function' => 'test',
        ];
        $mockRecord = $this->mockRecord($extra);

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: test() Test message', $result);
    }

    public function testFormatNoFunction()
    {
        $formatter = new CallerInlineFormatter();
        $extra = [
            'class' => '\\Tests\Unit\\Class',
        ];
        $mockRecord = $this->mockRecord($extra);

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: Class::{undefined}() Test message', $result);
    }

    public function testFormatNoExtras()
    {
        $formatter = new CallerInlineFormatter();
        $mockRecord = $this->mockRecord();

        $result = $formatter->format($mockRecord);
        // Trim trailing newline
        $result = trim($result);

        $this->assertEquals('[2000-01-01 00:00:00] phpunit.TEST: Test message', $result);
    }

    /**
     * Provides a mock record for use in other tests
     *
     * @param array $extra
     * @return array
     */
    private function mockRecord(array $extra = [])
    {
        return [
            'message' => 'Test message',
            'channel' => 'phpunit',
            'datetime' => '2000-01-01 00:00:00',
            'level_name' => 'TEST',
            'context' => [],
            'extra' => $extra
        ];
    }
}
