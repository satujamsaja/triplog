<?php


namespace TriplogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TriplogBundle\Repository\TripRepository")
 * @ORM\Table(name="trip")
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="trip")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $tripName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tripDesc;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="TripLocation", mappedBy="trip")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private $tripLocations;

    public function __construct()
    {
        $this->tripLocations = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getTripName()
    {
        return $this->tripName;
    }

    /**
     * @param mixed $tripName
     */
    public function setTripName($tripName)
    {
        $this->tripName = $tripName;
    }

    /**
     * @return mixed
     */
    public function getTripDesc()
    {
        return $this->tripDesc;
    }

    /**
     * @param mixed $tripDesc
     */
    public function setTripDesc($tripDesc)
    {
        $this->tripDesc = $tripDesc;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return ArrayCollection|TripLocation[]
     */
    public function getTripLocations()
    {
        return $this->tripLocations;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    public function __toString()
    {
       return $this->getTripName();
    }


}