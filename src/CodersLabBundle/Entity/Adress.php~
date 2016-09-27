<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adress
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\AdressRepository")
 */
class Adress
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100)
     * @Assert\NotBlank(
     *      message = "Miasto nie może być puste")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=100)
     * @Assert\NotBlank(
     *      message = "Ulica nie może być pusta")
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number", type="string", length=10)
     * @Assert\NotBlank(
     *      message = "Numer domu nie może być pusty")
     */
    private $houseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="apartment_number", type="string", length=10)
     */
    private $apartmentNumber;
    
    /**
     * @ORM\ManyToOne(targetEntity="Persons", inversedBy="adress")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $person;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Adress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Adress
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     * @return Adress
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string 
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set apartmentNumber
     *
     * @param string $apartmentNumber
     * @return Adress
     */
    public function setApartmentNumber($apartmentNumber)
    {
        $this->apartmentNumber = $apartmentNumber;

        return $this;
    }

    /**
     * Get apartmentNumber
     *
     * @return string 
     */
    public function getApartmentNumber()
    {
        return $this->apartmentNumber;
    }

    /**
     * Set person
     *
     * @param \CodersLabBundle\Entity\Persons $person
     * @return Adress
     */
    public function setPerson(\CodersLabBundle\Entity\Persons $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \CodersLabBundle\Entity\Persons 
     */
    public function getPerson()
    {
        return $this->person;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->person = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add person
     *
     * @param \CodersLabBundle\Entity\Persons $person
     * @return Adress
     */
    public function addPerson(\CodersLabBundle\Entity\Persons $person)
    {
        $this->person[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \CodersLabBundle\Entity\Persons $person
     */
    public function removePerson(\CodersLabBundle\Entity\Persons $person)
    {
        $this->person->removeElement($person);
    }
}
