<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use functions\functions;


class SayHelloTest extends TestCase
{
    protected $function;

    protected function setUp(): void
    {
        $this->function = new Functions();
    }

    public function testPositive()
    {
        $this->assertEquals('Hello', $this->function->sayHello());
    }
}
