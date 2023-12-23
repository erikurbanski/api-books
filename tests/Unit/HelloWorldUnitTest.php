<?php

namespace Tests\Unit;

use Core\HelloWorld;
use PHPUnit\Framework\TestCase;

class HelloWorldUnitTest extends TestCase
{
    public function testCallMethodFoo()
    {
        $test = new HelloWorld();
        $response = $test->foo();
        $this->assertEquals('Hello world!', $response);
    }
}