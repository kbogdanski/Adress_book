<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persons
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\PersonsRepository")
 */
class Persons
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
     * @ORM\Column(name="name", type="string", length=50)
     * @Assert\NotBlank(
     *      message = "Imię nie może być puste")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100)
     * @Assert\NotBlank(
     *      message = "Nazwisko nie może być puste")
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     * @Assert\File(
     *      maxSize = "1M",
     *      maxSizeMessage = "Rozmiar obrazka nie może przekraczać 1MB",
     *      mimeTypes = {"image/jpg", "image/jpeg", "image/png"},
     *      mimeTypesMessage = "Dopuszcalne pliki jpg lub png")
     */
    private $photo;
    
    /**
     * @ORM\OneToMany(targetEntity="Adress", mappedBy="person")
     * 
     */
    private $adress;
    
    /**
     * @ORM\OneToMany(targetEntity="Phones", mappedBy="person")
     * 
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity="Emails", mappedBy="person")
     * 
     */
    private $emails;
    
    /**
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="persons")
     * @ORM\JoinTable(name="users_groups")
     */
    private $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adress = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Persons
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Persons
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
    
    /**
     * Get surnameName
     *
     * @return string 
     */
    public function getSurnameName() {
        
        return $this->surname.' '.$this->name;
        
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Persons
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Persons
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set adress
     *
     * @param \CodersLabBundle\Entity\Adress $adress
     * @return Persons
     */
    public function setAdress(\CodersLabBundle\Entity\Adress $adress = null)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return \CodersLabBundle\Entity\Adress 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Add adress
     *
     * @param \CodersLabBundle\Entity\Adress $adress
     * @return Persons
     */
    public function addAdress(\CodersLabBundle\Entity\Adress $adress)
    {
        $this->adress[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \CodersLabBundle\Entity\Adress $adress
     */
    public function removeAdress(\CodersLabBundle\Entity\Adress $adress)
    {
        $this->adress->removeElement($adress);
    }

    /**
     * Add phones
     *
     * @param \CodersLabBundle\Entity\Phones $phones
     * @return Persons
     */
    public function addPhone(\CodersLabBundle\Entity\Phones $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \CodersLabBundle\Entity\Phones $phones
     */
    public function removePhone(\CodersLabBundle\Entity\Phones $phones)
    {
        $this->phones->removeElement($phones);
    }
    
    /**
     * Set phones
     *
     * @param \CodersLabBundle\Entity\Adress $phones
     * @return Persons
     */
    public function setPhones(\CodersLabBundle\Entity\Adress $phones = null)
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add emails
     *
     * @param \CodersLabBundle\Entity\Emails $emails
     * @return Persons
     */
    public function addEmail(\CodersLabBundle\Entity\Emails $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \CodersLabBundle\Entity\Emails $emails
     */
    public function removeEmail(\CodersLabBundle\Entity\Emails $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }
    
    /**
     * Set emails
     *
     * @param \CodersLabBundle\Entity\Adress $emails
     * @return Persons
     */
    public function setEmails(\CodersLabBundle\Entity\Adress $emails = null)
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Add groups
     *
     * @param \CodersLabBundle\Entity\Groups $groups
     * @return Persons
     */
    public function addGroup(\CodersLabBundle\Entity\Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \CodersLabBundle\Entity\Groups $groups
     */
    public function removeGroup(\CodersLabBundle\Entity\Groups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

}
