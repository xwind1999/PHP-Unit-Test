<?php


namespace App\Tests\AppBundle\Service;


use App\Tests\AppBundle\Entity\Dinosaur;
use App\Tests\AppBundle\Entity\Enclosure;
use App\Tests\AppBundle\Exception\NotABuffetException;
use App\Tests\AppBundle\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    /**
     * @throws NotABuffetException
     */
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->atLeastOnce())
            ->method('flush');
+
        $dinoFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'));
        $builder = new EnclosureBuilderService($em, $dinoFactory);

        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}