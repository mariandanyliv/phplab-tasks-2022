<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use functions\functions;


class CountArgumentsWrapperTest extends TestCase
{
    protected Functions $functions;

    protected function setUp(): void
    {
        $this->functions = new Functions();
    }

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->countArgumentsWrapper('Hello', [1, 2, 3]);
    }
}
