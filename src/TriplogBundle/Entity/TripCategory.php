<?php


namespace TriplogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\NotBlank()
     */
    private $tripCatName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(maxSize="5M", maxSizeMessage="Please upload file below 5MB", mimeTypes={"image/jpeg", "image/png"}, mimeTypesMessage="Please upload jpg or png image")
     */
    private $tripCatImage;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
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
        $this->createdAt = new \DateTime('now');
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

    public function __toString()
    {
        return $this->getTripCatName();
    }

    /**
     * @return mixed
     */
    public function getTripCatImage()
    {
        return $this->tripCatImage;
    }

    /**
     * @param mixed $tripCatImage
     */
    public function setTripCatImage($tripCatImage)
    {
        $this->tripCatImage = $tripCatImage;
    }

}