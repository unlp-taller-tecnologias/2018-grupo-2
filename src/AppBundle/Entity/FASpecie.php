<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FASpecie
 *
 * @UniqueEntity("name", message="El nombre ya está en uso.")
 * @ORM\Table(name="f_a_specie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FASpecieRepository")
 */
class FASpecie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * Many FASpecies have Many FASubspecies.
     * @ORM\OneToMany(targetEntity="FASubspecie", mappedBy="specie")
     */

    private $subspecies;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FASpecie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * Get subspecies.
     *
     * @return FASubspecie
     */
    public function getSubspecies()
    {
        return $this->subspecies;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted=false;

    /**
     * Set deleted.
     *
     * @param boolean $deleted
     *
     * @return FASpecie
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
