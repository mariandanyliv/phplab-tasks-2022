<?php

use PHPUnit\Framework\TestCase;

class SayHelloTest extends TestCase
{
    protected $function;

    protected function setUp(): void
    {
        $this->function = new functions\Functions();
    }

    public function testPositive()
    {
        $this->assertEquals('Hello', $this->function->sayHello());
    }
}
