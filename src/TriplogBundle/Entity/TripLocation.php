<?php


namespace TriplogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TriplogBundle\Repository\TripLocationRepository")
 * @ORM\Table(name="trip_location")
 */
class TripLocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Trip", inversedBy="tripLocations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $trip;

    /**
     * @ORM\ManyToOne(targetEntity="TripCategory", inversedBy="tripLocations")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private $tripCategory;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tripLocation")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="TripImage", mappedBy="tripLocation")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private $tripLocImg;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $tripLocName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tripLocDesc;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tripLatLon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $createdAt;

    public function __construct()
    {
        $this->tripLocImg = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getTripLocName()
    {
        return $this->tripLocName;
    }

    /**
     * @param mixed $tripLocName
     */
    public function setTripLocName($tripLocName)
    {
        $this->tripLocName = $tripLocName;
    }

    /**
     * @return mixed
     */
    public function getTripLocDesc()
    {
        return $this->tripLocDesc;
    }

    /**
     * @param mixed $tripLocDesc
     */
    public function setTripLocDesc($tripLocDesc)
    {
        $this->tripLocDesc = $tripLocDesc;
    }

    /**
     * @return mixed
     */
    public function getTripLatLon()
    {
        return $this->tripLatLon;
    }

    /**
     * @param mixed $tripLatLon
     */
    public function setTripLatLon($tripLatLon)
    {
        $this->tripLatLon = $tripLatLon;
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
    public function getTrip()
    {
        return $this->trip;
    }

    /**
     * @param mixed $trip
     */
    public function setTrip(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * @return mixed
     */
    public function getTripCategory()
    {
        return $this->tripCategory;
    }

    /**
     * @param mixed $tripCategory
     */
    public function setTripCategory(TripCategory $tripCategory)
    {
        $this->tripCategory = $tripCategory;
    }

    /**
     * @return ArrayCollection|TripImage[]
     */
    public function getTripLocImg()
    {
        return $this->tripLocImg;
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



}