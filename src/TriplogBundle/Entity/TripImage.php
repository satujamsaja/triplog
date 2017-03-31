<?php


namespace TriplogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="TripLocation", inversedBy="tripImage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tripLocation;

    /**
     * @ORM\Column(type="string")
     */
    private $tripImgUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
    public function getTripImgUrl()
    {
        return $this->tripImgUrl;
    }

    /**
     * @param mixed $tripImgUrl
     */
    public function setTripImgUrl($tripImgUrl)
    {
        $this->tripImgUrl = $tripImgUrl;
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