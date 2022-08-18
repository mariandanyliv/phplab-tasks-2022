<?php

namespace functions;

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    protected Functions $functions;

    protected function setUp(): void
    {
        $this->functions = new Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($expected, ...$input)
    {
        $this->assertEquals($expected, $this->functions->countArguments(...$input));
    }

    public function positiveDataProvider(): array
    {
        return [
            [
                [
                    'argument_count' => null,
                    'argument_values' => []
                ],
            ],
            [
                [
                    'argument_count' => 1,
                    'argument_values' => [0 => "one"]
                ],
                "one"
            ],
            [
                [
                    'argument_count' => 2,
                    'argument_values' => [0 => "one", 1 => "two"]
                ],
                "one", "two"
            ]
        ];
    }
}
