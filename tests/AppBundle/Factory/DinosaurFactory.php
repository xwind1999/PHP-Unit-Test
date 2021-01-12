<?php


namespace App\Tests\AppBundle\Factory;


use App\Tests\AppBundle\Entity\Dinosaur;
use Exception;

class DinosaurFactory
{

    /**
     * DinosaurFactory constructor.
     */
    public function __construct()
    {

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
        $length = $this->getLengthFromSpecification($specification);
        $isCarnivorous = false;
        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }
        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

    /**
     * @param string $specification
     * @return int
     * @throws Exception
     */
    private function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            '😱' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];

        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;
        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);
            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];
                break;
            }
        }
        return random_int($minLength, $maxLength);
    }
}