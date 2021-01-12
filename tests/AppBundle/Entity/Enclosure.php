<?php


namespace App\Tests\AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\TestCase;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosures")
 * Class Enclosure
 * @package App\Tests\AppBundle\Entity
 */
class Enclosure extends TestCase
{

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"}
     */
    private $dinosaurs;

    /**
     * Enclosure constructor.
     */
    public function __construct()
    {
        $this->dinosaurs = new ArrayCollection();
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        $this->dinosaurs[] = $dinosaur;
    }

    /**
     * @return Collection
     */
    public function getDinosaurs()
    {
        return $this->dinosaurs;
    }

}