<?php


namespace App\Tests\AppBundle\Factory;


use App\Tests\AppBundle\Entity\Dinosaur;
use App\Tests\AppBundle\Service\DinosaurLengthDeterminator;
use Exception;

class DinosaurFactory
{
    /**
     * @var DinosaurLengthDeterminator
     */
    private $lengthDeterminator;

    /**
     * DinosaurFactory constructor.
     * @param DinosaurLengthDeterminator $lengthDeterminator
     */
    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    /**
     * @param string $specification
     * @return Dinosaur
     * @throws Exception
     */
    public function growFromSpecification(string $specification): Dinosaur
    {
        $codeName = 'InG-' . random_int(1, 9999);
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;
        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }
        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }
}