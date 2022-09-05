<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use functions\functions;


class FunctionsTest extends TestCase
{
    protected Functions $function;

    protected function setUp(): void
    {
        $this->function = new Functions();
    }

    public function testSayHelloPositive()
    {
        $this->assertEquals('Hello', $this->function->sayHello());
    }

    /**
     * @dataProvider positiveSayHelloArgumentDataProvider
     */
    public function testSayHelloArgumentPositive($input, $expected)
    {
        $this->assertEquals($expected, $this->function->sayHelloArgument($input));
    }

    public function positiveSayHelloArgumentDataProvider(): array
    {
        return [
            ['world!', 'Hello world!'],
            ['', 'Hello '],
            ['світ', 'Hello світ'],
            [1, 'Hello 1'],
            [1.2, 'Hello 1.2'],
        ];
    }

    /**
     * @dataProvider  negativeSayHelloArgumentWrapperDaraProvider
     */
    public function testSayHelloArgumentWrapperNegative($input)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->function->sayHelloArgumentWrapper(['Say Hello']);

    }

    public function negativeSayHelloArgumentWrapperDaraProvider()
    {
        return [
            ['Say Hello'],
            [null]
        ];
    }

    public function testSayHelloArgumentWrapperPositive()
    {
        $this->assertEquals('Hello world!', $this->function->sayHelloArgumentWrapper('world!'));
    }

    /**
     * @dataProvider positiveCountArgumentDataProvider
     */
    public function testCountArgumentsPositive($expected, ...$input)
    {
        $this->assertEquals($expected, $this->function->countArguments(...$input));
    }

    public function positiveCountArgumentDataProvider(): array
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
                    'argument_values' => [0 => 'one']
                ],
                'one'
            ],
            [
                [
                    'argument_count' => 2,
                    'argument_values' => [0 => 'one', 1 => 'two']
                ],
                'one', 'two'
            ]
        ];
    }

    /**
     * @dataProvider negativeCountArgumentWrapperDataProvider
     */
    public function testCountArgumentsWrapperNegative($input, $args)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->function->countArgumentsWrapper($input, $args);
    }

    public function negativeCountArgumentWrapperDataProvider()
    {
        return [
            ['Hello', [1, 2, 3]],
            [123, null]
        ];
    }
}
