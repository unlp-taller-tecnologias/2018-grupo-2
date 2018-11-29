<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flora
 *
 * @ORM\Table(name="flora")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FloraRepository")
 */
class Flora
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
     * @var string|null
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="floras")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="FLSubspecie", inversedBy="floras")
     * @ORM\JoinColumn(name="subspecie_id", referencedColumnName="id", nullable=false)
     */
    private $subspecie;

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
     * Set observations.
     *
     * @param string|null $observations
     *
     * @return Flora
     */
    public function setObservations($observations = null)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations.
     *
     * @return string|null
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set age.
     *
     * @param int $age
     *
     * @return Flora
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set image.
     *
     * @param string|null $image
     *
     * @return Flora
     */
    public function setImage($image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Flora
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
     * Set area.
     *
     * @param string $area
     *
     * @return Flora
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area.
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set subspecie.
     *
     * @param string $subspecie
     *
     * @return Flora
     */
    public function setSubspecie($subspecie)
    {
        $this->subspecie = $subspecie;

        return $this;
    }

    /**
     * Get subspecie.
     *
     * @return string
     */
    public function getSubspecie()
    {
        return $this->subspecie;
    }
}
