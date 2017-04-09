<?php


namespace TriplogBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use TriplogBundle\Entity\TripLocation;

class TripDataRenderer
{
    private $entityManager;
    private $router;

    public function __construct(EntityManagerInterface $entityManager, Router $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }


    public function TripRenderData() {
        // Get all public trip.
        $trips = $this->entityManager->getRepository('TriplogBundle:Trip')
            ->findAllPublicOrderByDate();

        // Generate proper data for json.
        $arrayContent['trips'] = [];
        foreach($trips as $index => $trip) {
            $arrayContent['trips'][] = [
                'id' => $trip->getId(),
                'tripName' => $trip->getTripName(),
                'tripDesc' => $trip->getTripDesc(),
                'createdAt' => $trip->getCreatedAt()->format("F d Y, H:ma"),
                'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                'link' => $this->router->generate('trip_show', [
                    'id' => $trip->getId(),
                ]),
            ];
        }

        return $arrayContent;
    }

    public function TripRenderLocation($trip)
    {

        // Get all locations on trips.
        $tripLocs = $trip->getTripLocations()
            ->filter(function (TripLocation $tripLocation) {
                return $tripLocation->getIsPublic() == true;
            });

        $arrayContent['locations'] = [];
        if($tripLocs) {
            $index = 0;
            foreach($tripLocs as $tripLoc) {
                // Get Images on this locations.
                $tripLocImages = $tripLoc->getTripLocImg();
                $tripLocImg = [];
                if($tripLocImages) {
                    foreach($tripLocImages as $tripLocImage) {
                        $tripLocImg[] = $tripLocImage->getTripImgUrl();
                    }
                }

                $arrayContent['locations'][] = [
                    'id' => $tripLoc->getId(),
                    'tripCategory' => $tripLoc->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLoc->getTripLocName(),
                    'tripLocDesc' => $tripLoc->getTripLocDesc(),
                    'tripLocImg' => $tripLocImg,
                    'tripLatLon' => (!empty($tripLoc->getTripLatLon())) ? explode(",", $tripLoc->getTripLatLon()) : [],
                    'createdAt' => $tripLoc->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->router->generate('trip_location_show', [
                        'id' => $tripLoc->getId(),
                    ]),
                    'linkCat' => $this->router->generate('trip_category_show', [
                        'id' => $tripLoc->getTripCategory()->getId(),
                    ]),
                    'linkTrip' => $this->router->generate('trip_show', [
                        'id' => $tripLoc->getTrip()->getId(),
                    ]),
                ];
                $index++;
            }
        }

        return $arrayContent;

    }

    public function TripRenderMap()
    {
        // Get latest trip location.
        $tripLocs = $this->entityManager->getRepository('TriplogBundle:TripLocation')
            ->findSomePublicOrderByDate();

        $arrayContent['locations'] = [];
        if($tripLocs) {
            $index = 0;
            foreach($tripLocs as $tripLoc) {
                // Get Images on this locations.
                $tripLocImages = $tripLoc->getTripLocImg();
                $tripLocImg = [];
                if($tripLocImages) {
                    foreach($tripLocImages as $tripLocImage) {
                        $tripLocImg[] = $tripLocImage->getTripImgUrl();
                    }
                }

                $arrayContent['locations'][] = [
                    'id' => $tripLoc->getId(),
                    'tripCategory' => $tripLoc->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLoc->getTripLocName(),
                    'tripLocDesc' => $tripLoc->getTripLocDesc(),
                    'tripLocImg' => $tripLocImg,
                    'tripLatLon' => (!empty($tripLoc->getTripLatLon())) ? explode(",", $tripLoc->getTripLatLon()) : [],
                    'createdAt' => $tripLoc->getCreatedAt()->format("F d Y, H:ma"),
                    'link' => $this->router->generate('trip_location_show', [
                        'id' => $tripLoc->getId(),
                    ]),
                    'linkCat' => $this->router->generate('trip_category_show', [
                        'id' => $tripLoc->getTripCategory()->getId(),
                    ]),
                    'linkTrip' => $this->router->generate('trip_show', [
                        'id' => $tripLoc->getTrip()->getId(),
                    ]),
                ];
                $index++;
            }
        }

        return $arrayContent;
    }

    public function TripRenderLocationData()
    {
        // Get latest locations.
        $tripLocations = $this->entityManager->getRepository('TriplogBundle:TripLocation')
            ->findAllPublicOrderByDate();

        $arrayContent['locations'] = [];
        if($tripLocations) {
            foreach($tripLocations as $index => $tripLocation) {
                // Get Images on this locations.
                $tripLocImages = $tripLocation->getTripLocImg();
                $tripLocImg = [];
                if($tripLocImages) {
                    foreach($tripLocImages as $tripLocImage) {
                        $tripLocImg[] = $tripLocImage->getTripImgUrl();
                    }
                }

                $arrayContent['locations'][] = [
                    'id' => $tripLocation->getId(),
                    'tripCategory' => $tripLocation->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLocation->getTripLocName(),
                    'tripLocDesc' => $tripLocation->getTripLocDesc(),
                    'tripLatLon' => $tripLocation->getTripLatLon(),
                    'tripLocImg' => $tripLocImg,
                    'createdAt' => $tripLocation->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->router->generate('trip_location_show', [
                        'id' => $tripLocation->getId(),
                    ]),
                    'linkCat' => $this->router->generate('trip_category_show', [
                        'id' => $tripLocation->getTripCategory()->getId(),
                    ]),
                    'linkTrip' => $this->router->generate('trip_show', [
                        'id' => $tripLocation->getTrip()->getId(),
                    ]),
                ];
            }
        }

        return $arrayContent;

    }

    public function TripRenderCategoriesData()
    {
        // Get list all category,
        $categories = $this->entityManager->getRepository('TriplogBundle:TripCategory')
            ->findAllOrderByName();

        // Generate proper data for json.
        $arrayContent['categories'] = [];
        foreach($categories as $index => $category) {
            $arrayContent['categories'][] = [
                'id' => $category->getId(),
                'tripCatName' => $category->getTripCatName(),
                'link' => $this->router->generate('trip_category_show', [
                    'id' => $category->getId(),
                ]),
            ];
        }

        return $arrayContent;
    }

    public function TripRenderLocationCategory($tripCategory) {
        // Get all locations on category.
        $tripLocs = $tripCategory->getTripLocations()
            ->filter(function (TripLocation $tripLocation) {
                return $tripLocation->getIsPublic() == true;
            });

        $arrayContent['locations'] = [];
        if($tripLocs) {
            $index = 0;
            foreach($tripLocs as $tripLoc) {
                // Get Images on this locations.
                $tripLocImages = $tripLoc->getTripLocImg();
                $tripLocImg = [];
                if($tripLocImages) {
                    foreach($tripLocImages as $tripLocImage) {
                        $tripLocImg[] = $tripLocImage->getTripImgUrl();
                    }
                }

                $arrayContent['locations'][] = [
                    'id' => $tripLoc->getId(),
                    'tripCategory' => $tripLoc->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLoc->getTripLocName(),
                    'tripLocDesc' => $tripLoc->getTripLocDesc(),
                    'tripLocImg' => $tripLocImg,
                    'tripLatLon' => (!empty($tripLoc->getTripLatLon())) ? explode(",", $tripLoc->getTripLatLon()) : [],
                    'createdAt' => $tripLoc->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->router->generate('trip_location_show', [
                        'id' => $tripLoc->getId(),
                    ]),
                    'linkCat' => $this->router->generate('trip_category_show', [
                        'id' => $tripLoc->getTripCategory()->getId(),
                    ]),
                    'linkTrip' => $this->router->generate('trip_show', [
                        'id' => $tripLoc->getTrip()->getId(),
                    ]),
                ];
                $index++;
            }
        }

        return $arrayContent;
    }

}