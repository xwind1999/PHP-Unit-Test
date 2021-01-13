<?php

namespace App\Tests\AppBundle\Service;

use App\Tests\AppBundle\Exception\NotABuffetException;
use App\Tests\AppBundle\Factory\DinosaurFactory;
use App\Tests\AppBundle\Entity\Enclosure;
use App\Tests\AppBundle\Entity\Security;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DinosaurFactory
     */
    private $dinosaurFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        DinosaurFactory $dinosaurFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->dinosaurFactory = $dinosaurFactory;
    }

    /**
     * @param int $numberOfSecuritySystems
     * @param int $numberOfDinosaurs
     * @return Enclosure
     * @throws NotABuffetException
     */
    public function buildEnclosure(
        int $numberOfSecuritySystems = 1,
        int $numberOfDinosaurs = 3
    ): Enclosure
    {
        $enclosure = new Enclosure();

        $this->addSecuritySystems($numberOfSecuritySystems, $enclosure);

        $this->addDinosaurs($numberOfDinosaurs, $enclosure);

        $this->entityManager->persist($enclosure);

        $this->entityManager->flush();

        return $enclosure;
    }

    private function addSecuritySystems(int $numberOfSecuritySystems, Enclosure $enclosure)
    {
        $securityNames = ['Fence', 'Electric fence', 'Guard tower'];
        for ($i = 0; $i < $numberOfSecuritySystems; $i++) {
            $securityName = $securityNames[array_rand($securityNames)];
            $security = new Security($securityName, true, $enclosure);

            $enclosure->addSecurity($security);
        }
    }

    /**
     * @param int $numberOfDinosaurs
     * @param Enclosure $enclosure
     * @throws NotABuffetException
     * @throws \Exception
     */
    private function addDinosaurs(int $numberOfDinosaurs, Enclosure $enclosure)
    {
        $lengths = ['small', 'large', 'huge'];
        $diets = ['herbivore', 'carnivorous'];
        // We should not mix herbivore and carnivorous together,
        // so use the same diet for every dinosaur.
        $diet = $diets[array_rand($diets)];

        for ($i = 0; $i < $numberOfDinosaurs; $i++) {
            $length = $lengths[array_rand($lengths)];
            $specification = "{$length} {$diet} dinosaur";
            $dinosaur = $this->dinosaurFactory->growFromSpecification($specification);
            $enclosure->addDinosaur($dinosaur);
        }
    }
}
