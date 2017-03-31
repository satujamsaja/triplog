<?php

namespace TriplogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use TriplogBundle\Entity\Trip;
use TriplogBundle\Entity\TripLocation;


class TripController extends Controller
{
    /**
     * @Route("/trips", name="trip_list")
     */
    public function indexAction()
    {
        return $this->render('TriplogBundle:Trip:list.html.twig');
    }

    /**
     * @Route("/api/trip/list", name="api_trip_list")
     */
    public function apiListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('TriplogBundle:Trip')
            ->findAllPublicOrderByDate();

        // Generate proper trips data for json.
        $arrayContent['trips'] = [];
        foreach($trips as $index => $trip) {
            $arrayContent['trips'][] = [
                'id' => $trip->getId(),
                'tripName' => $trip->getTripName(),
                'tripDesc' => $trip->getTripDesc(),
                'createdAt' => $trip->getCreatedAt()->format("F d Y, H:ma"),
                'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                'link' => $this->generateUrl('trip_show', [
                    'id' => $trip->getId(),
                ]),
            ];
        }

        return new JsonResponse($arrayContent);
    }

    /**
     * @Route("/api/trip/{id}", name="api_trip_view")
     */
    public function apiShowAction(Trip $trip)
    {
        // Get all locations on trips.
        $tripLocs = $trip->getTripLocations()
            ->filter(function (TripLocation $tripLocation) {
                return $tripLocation->getIsPublic() == true;
            });

        // Reindex array keys.

        $arrayContent['tripLocations'] = [];
        if($tripLocs) {
            $index = 0;
            foreach($tripLocs as $tripLoc) {
                $arrayContent['tripLocations'][] = [
                    'id' => $tripLoc->getId(),
                    'tripCategory' => $tripLoc->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLoc->getTripLocName(),
                    'tripLocDesc' => $tripLoc->getTripLocDesc(),
                    'tripLocImg' => $tripLoc->getTripLocImg(),
                    'tripLatLon' => (!empty($tripLoc->getTripLatLon())) ? explode(",", $tripLoc->getTripLatLon()) : [],
                    'createdAt' => $tripLoc->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->generateUrl('trip_location_show', [
                        'id' => $tripLoc->getId(),
                    ]),
                ];
                $index++;
            }
        }

        return new JsonResponse($arrayContent);

    }

    /**
     * @Route("/trip/{id}", name="trip_show")
     */
    public function showAction(Trip $trip)
    {
        // Get this trip, return not found if is not public.
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('TriplogBundle:Trip')
            ->findOnePublicById($trip->getId());

        if(!$trip) {
            throw $this->createNotFoundException('No trip found');
        }

        return $this->render('TriplogBundle:Trip:show.html.twig', [
            'trip' => $trip,
        ]);
    }

}