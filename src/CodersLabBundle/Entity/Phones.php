<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Phones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Phones
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
     * @ORM\Column(name="phone_number", type="string", length=20)
     * @Assert\NotBlank(
     *      message = "Numer telefonu nie może być pusty")
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Persons", inversedBy="phones")
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Phones
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Phones
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set person
     *
     * @param \CodersLabBundle\Entity\Persons $person
     * @return Phones
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
}
