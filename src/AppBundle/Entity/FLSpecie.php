<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FLSpecie
 *
* @UniqueEntity("name", message="El nombre ya está en uso.")
 * @ORM\Table(name="f_l_specie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FLSpecieRepository")
 */
class FLSpecie
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
     * Many FLSpecies have Many FLSubspecies.
     * @ORM\OneToMany(targetEntity="FLSubspecie", mappedBy="specie")
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
     * @return FLSpecie
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
     * @return FLSpecie
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
