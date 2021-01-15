<?php


namespace App\Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;
use stdClass;

class FooTest extends TestCase
{
    public function testIdenticalObjectPassed()
    {
        $expectedObject = new \stdClass();

        $mock = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['foo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }

    public function testIdenticalObjectPassedWithParameters() : void
    {
        $expectedObject = new stdClass;

        $cloneArguments = true;
        $mock = $this->getMockBuilder(\stdClass::class)
            ->enableArgumentCloning()
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }
}