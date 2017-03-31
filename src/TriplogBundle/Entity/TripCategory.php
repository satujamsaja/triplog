<?php


namespace TriplogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TriplogBundle\Repository\TripCategoryRepository")
 * @ORM\Table(name="trip_category")
 */
class TripCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $tripCatName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="TripLocation", mappedBy="tripCategory")
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
    public function getTripCatName()
    {
        return $this->tripCatName;
    }

    /**
     * @param mixed $tripCatName
     */
    public function setTripCatName($tripCatName)
    {
        $this->tripCatName = $tripCatName;
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
     * @return ArrayCollection|TripLocation[]
     */
    public function getTripLocations()
    {
        return $this->tripLocations;
    }


}