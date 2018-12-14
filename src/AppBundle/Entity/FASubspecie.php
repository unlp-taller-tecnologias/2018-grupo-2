<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * FASubspecie
 *
 * @UniqueEntity("name", message="El nombre ya está en uso.")
 * @ORM\Table(name="f_a_subspecie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FASubspecieRepository")
 */
class FASubspecie
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
     * Many FASubspecies have Many Faunas.
     * @ORM\OneToMany(targetEntity="Fauna", mappedBy="subspecie")
     */

    private $faunas;

    /**
     * @ORM\ManyToOne(targetEntity="FASpecie", inversedBy="subspecies")
     * @ORM\JoinColumn(name="specie_id", referencedColumnName="id", nullable=false)
     */
    private $specie;

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
     * @return FASubspecie
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

    /**
     * Set specie.
     *
     * @param string $specie
     *
     * @return FLSubspecie
     */
    public function setSpecie($specie)
    {
        $this->specie = $specie;

        return $this;
    }

    /**
     * Get specie.
     *
     * @return string
     */
    public function getSpecie()
    {
        return $this->specie;
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
     * @return FASubspecie
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

    /**
     * Get FASpecie.
     *
     * @return FASpecie
     */
    public function getFASpecie()
    {
        return $this->specie;
    }
}
