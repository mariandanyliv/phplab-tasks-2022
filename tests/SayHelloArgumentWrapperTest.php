<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use functions\functions;
use InvalidArgumentException;


class SayHelloArgumentWrapperTest extends TestCase
{
    protected $function;

    protected function setUp(): void
    {
        $this->function = new Functions();
    }

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->function->sayHelloArgumentWrapper(['Say Hello']);
    }

    public function testPositive()
    {
        $this->assertEquals('Hello world!', $this->function->sayHelloArgumentWrapper('world!'));
    }
}
