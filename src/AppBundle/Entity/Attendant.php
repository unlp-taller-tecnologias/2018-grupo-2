<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Attendant
 *
 * @UniqueEntity("email", message="El email ya está en uso.")
 * @ORM\Table(name="attendant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttendantRepository")
 */
class Attendant
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
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="attendants")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Many Attendants have Many Faunas.
     * @ORM\ManyToMany(targetEntity="Fauna", mappedBy="attendants")
     */
    private $faunas;

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
     * Set email.
     *
     * @param string $email
     *
     * @return Attendant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Attendant
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
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Attendant
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return Attendant
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString(){
        return $this->name." ".$this->lastName;
    }


    /**
     * Get faunas.
     *
     * @return Fauna
     */
    public function getFaunas()
    {
        return $this->faunas;
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
     * @return Attendant
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
     * @var int
     *
     * @ORM\Column(name="doc_num", type="integer")
     */
     private $doc_num;
    /**
     * Set doc_num.
     *
     * @param int $doc_num
     *
     * @return Attendant
     */
    public function setDocNum($doc_num)
    {
        $this->doc_num = $doc_num;

        return $this;
    }

    /**
     * Get doc_num.
     *
     * @return int
     */
    public function getDocNum()
    {
        return $this->doc_num;
    }
}
