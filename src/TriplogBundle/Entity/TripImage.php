<?php


namespace TriplogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="TriplogBundle\Repository\TripImageRepository")
 * @ORM\Table(name="trip_image")
 */
class TripImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="TripLocation", inversedBy="tripLocImg")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $tripLocation;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(maxSize="5M", maxSizeMessage="Please upload file below 5MB", mimeTypes={"image/jpg", "image/png"}, mimeTypesMessage="Please upload jpg or png image")
     */
    private $tripImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
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
    public function getTripLocation()
    {
        return $this->tripLocation;
    }

    /**
     * @param mixed $tripLocation
     */
    public function setTripLocation(TripLocation $tripLocation)
    {
        $this->tripLocation = $tripLocation;
    }

    /**
     * @return mixed
     */
    public function getTripImage()
    {
        return $this->tripImage;
    }

    /**
     * @param mixed $tripImage
     */
    public function setTripImage($tripImage)
    {
        $this->tripImage = $tripImage;
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



}