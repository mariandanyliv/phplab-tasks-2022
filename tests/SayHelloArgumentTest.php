<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use functions\functions;

class sayHelloArgumentTest extends TestCase
{
    protected Functions $functions;

    protected function setUp(): void
    {
        $this->functions = new Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($input));
    }

    public function positiveDataProvider(): array
    {
        return [
            ['world!', 'Hello world!'],
            ['', 'Hello '],
            ['світ', 'Hello світ'],
            [1, 'Hello 1'],
            [1.2, 'Hello 1.2'],
        ];
    }
}