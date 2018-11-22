<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fauna
 *
 * @ORM\Table(name="fauna")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FaunaRepository")
 */
class Fauna
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="health_observations", type="string", length=255)
     */
    private $healthObservations;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * Many Faunas have Many Attendants.
     * @ORM\ManyToMany(targetEntity="Attendant", inversedBy="faunas")
     * @ORM\JoinTable(name="faunas_attendants")
     */
    private $attendants;

    /**
     * @ORM\ManyToOne(targetEntity="Destination", inversedBy="faunas")
     * @ORM\JoinColumn(name="destination_id", referencedColumnName="id", nullable=true)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="FASubspecie", inversedBy="faunas")
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
     * Set name.
     *
     * @param string $name
     *
     * @return Fauna
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
     * Set weight.
     *
     * @param float $weight
     *
     * @return Fauna
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set healthObservations.
     *
     * @param string $healthObservations
     *
     * @return Fauna
     */
    public function setHealthObservations($healthObservations)
    {
        $this->healthObservations = $healthObservations;

        return $this;
    }

    /**
     * Get healthObservations.
     *
     * @return string
     */
    public function getHealthObservations()
    {
        return $this->healthObservations;
    }

    /**
     * Set image.
     *
     * @param string|null $image
     *
     * @return Fauna
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
     * Set destination.
     *
     * @param string $destination
     *
     * @return Fauna
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set subspecie.
     *
     * @param string $subspecie
     *
     * @return Fauna
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

    /**
     * Set attendants.
     *
     * @param string $attendants
     *
     * @return Fauna
     */
    public function setAttendants($attendants)
    {
        $this->attendants = $attendants;

        return $this;
    }

    /**
     * Get attendants.
     *
     * @return string
     */
    public function getAttendants()
    {
        return $this->attendants;
    }
}
