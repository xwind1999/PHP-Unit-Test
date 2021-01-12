<?php


namespace App\Tests\AppBundle\Factory;


use App\Tests\AppBundle\Entity\Dinosaur;
use Exception;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $factory;

    /**
     *
     */
    public function setUp(): void
    {
        $this->factory = new DinosaurFactory();
    }

    public function testItGrowsALargeVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceraptors()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }

        $dinosaur = $this->factory->growVelociraptor(1);

        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     * @param string $spec
     * @param bool $expectedIsLarge
     * @param bool $expectedIsCarnivorous
     * @throws Exception
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsLarge, bool $expectedIsCarnivorous)
    {
        $dinosaur = $this->factory->growFromSpecification($spec);

        if ($expectedIsLarge) {
            $this->assertGreaterThanOrEqual(Dinosaur::LARGE, $dinosaur->getLength());
        } else {
            $this->assertLessThan(Dinosaur::LARGE, $dinosaur->getLength());
        }

        $this->assertSame($expectedIsCarnivorous, $dinosaur->getIsCarnivorous(), 'Diets do not match');
    }

    /**
     * @dataProvider getHugeDinosaurSpecTests
     * @param string $specification
     * @throws Exception
     */
    public function testItGrowsAHugeDinosaur(string $specification)
    {
        $dinosaur = $this->factory->growFromSpecification($specification);

        $this->assertGreaterThanOrEqual(Dinosaur::HUGE, $dinosaur->getLength());
    }

    public function getSpecificationTests(): array
    {
        return [
            ['large carnivorous dinosaur', true, true],
            ['give me all the cookies!!!', false, false],
            ['large herbivore', true, false],
        ];
    }

    public function getHugeDinosaurSpecTests(): array
    {
        return [
          ['huge dinosaur'],
          ['huge dino'],
          ['huge'],
          ['OMG'],
          ['😱']
        ];
    }
}