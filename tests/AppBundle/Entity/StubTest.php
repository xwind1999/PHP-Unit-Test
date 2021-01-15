<?php


namespace App\Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;

class StubTest extends TestCase
{
    public function testReturnArgumentStub()
    {
        $stub = $this->createStub(Sana::class);

        $stub->method('shy')->will($this->returnArgument(1));

        $this->assertSame('Sana', $stub->shy('foo', 'Sana'));

        $this->assertSame('Mina', $stub->shy('bar', 'Mina'));
    }

    public function testReturnSelf(): void
    {
        $stub = $this->createStub(Sana::class);

        $stub->method('shy')
            ->will($this->returnSelf());

        $this->assertSame($stub, $stub->shy());
    }

    public function testReturnValueMapStub()
    {
        $stub = $this->createStub(Sana::class);

        $map = [
            ['a', 'b', 'c', 'd', 1],
            ['e', 'f', 'g', 'h']
        ];

        $stub->method('shy')
            ->will($this->returnValueMap($map));

        $this->assertSame(1, $stub->shy('a', 'b', 'c', 'd'));
        $this->assertSame('h', $stub->shy('e', 'f', 'g'));
    }

    public function testReturnCallbackStub()
    {
        $stub = $this->createStub(Sana::class);

        $stub->method('shy')
            ->will($this->returnCallback(function ($text){
                return $text;
            })
            );
        $this->assertSame('Cheese Kimbap', $stub->shy('Cheese Kimbap'));
    }

    public function testOnConsecutiveCallsStub()
    {
        $stub = $this->createStub(Sana::class);

        $stub->method('shy')
            ->will($this->onConsecutiveCalls(2,3,5,7));

        // $stub->doSomething() returns a different value each time
        $this->assertSame(2, $stub->shy());
        $this->assertSame(3, $stub->shy());
        $this->assertSame(5, $stub->shy());
        $this->assertSame(7, $stub->shy());
        $this->assertSame(null, $stub->shy());

    }
}