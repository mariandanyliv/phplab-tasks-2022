<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    protected $function;

    protected function setUp(): void
    {
        $this->function = new functions\Functions();
    }

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->function->sayHelloArgumentWrapper(['Say Hello']);
    }
}
