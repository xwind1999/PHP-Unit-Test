<?php


namespace App\Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    public function testObserverAreUpdated()
    {
        // Create a mock for the Observer class
        // only mock the update method
        $observer = $this->createMock(Observer::class);

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter
        $observer->expects($this->once())
            ->method('update')
            ->with($this->equalTo('something'));

        // Create a Subject object and attach to the mocked
        // Observer object to it
        $subject = new Subject('My subject');
        $subject->attach($observer);

        // Call the doSomething() method on the $subject object
        // which we expect to call the mocked Observer object's
        // update() method with the string 'something'
        $subject->doSomething();

    }

    public function testErrorReported()
    {
        // Create a mock for the Observer class, mocking the
        // reportError() method
        $observer = $this->createMock(Observer::class);

        $observer->expects($this->once())
            ->method('reportError')
            ->with(
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->anything()
            );

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // The doSomethingBad() method should report an error to the observer
        // via the reportError() method
        $subject->doSomethingBad();
    }

    public function testFunctionCalledTwoTimesWithSpecificArguments()
    {
        $mock = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['set'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('foo'), $this->greaterThan(0)],
                [$this->equalTo('bar'), $this->greaterThan(0)]
            );

        $mock->set('foo', 21);
        $mock->set('bar', 24);
    }

    public function testErrorReportedCallback()
    {
        // Create a mock for the Observer class, mocking the reportError() method
        $observer = $this->createMock(Observer::class);

        $observer->expects($this->once())
            ->method('reportError')
            ->with(
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->callback(function ($subject){
                    return is_callable([$subject, 'getName']) && $subject->getName() == 'My subject';
                })
            );

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // The doSomethingBad() method should report an error to the observer
        // via the reportError() method
        $subject->doSomethingBad();
    }
}