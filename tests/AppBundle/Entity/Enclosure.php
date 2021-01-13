<?php


namespace App\Tests\AppBundle\Entity;


use App\Tests\AppBundle\Exception\DinosaursAreRunningRampantException;
use App\Tests\AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosures")
 * Class Enclosure
 * @package App\Tests\AppBundle\Entity
 */
class Enclosure
{

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"}
     */
    private $dinosaurs;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    /**
     * Enclosure constructor.
     * @param bool $withBasicSecurity
     */
    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if($withBasicSecurity){
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    /**
     * @param Dinosaur $dinosaur
     * @throws NotABuffetException
     */
    public function addDinosaur(Dinosaur $dinosaur)
    {
        if(!$this->isSecurityActive()){
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }
        if(!$this->canAddDinosaur($dinosaur)){
            throw new NotABuffetException();
        }
        $this->dinosaurs[] = $dinosaur;
    }

    /**
     * @return Collection
     */
    public function getDinosaurs()
    {
        return $this->dinosaurs;
    }

    private function canAddDinosaur(Dinosaur $dinosaur):bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->getIsCarnivorous() === $dinosaur->getIsCarnivorous();
    }

    /**
     * @return bool
     */
    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()){
                return true;
            }
        }

        return false;
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

    /**
     * @return Collection
     */
    public function getSecurities()
    {
        return $this->securities;
    }

}