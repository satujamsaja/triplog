<?php

namespace TriplogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use TriplogBundle\Entity\TripLocation;


class TripLocationController extends Controller
{
    /**
     * @Route("/locations", name="trip_locations")
     */
    public function indexAction()
    {
        return $this->render('TriplogBundle:Location:list.html.twig');
    }

    /**
     * @Route("/api/location/list", name="api_location_list")
     */
    public function apiListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tripLocations = $em->getRepository('TriplogBundle:TripLocation')
            ->findAllPublicOrderByDate();

        $arrayContent['locations'] = [];
        if($tripLocations) {
            foreach($tripLocations as $index => $tripLocation) {
                $arrayContent['locations'][] = [
                    'id' => $tripLocation->getId(),
                    'tripCategory' => $tripLocation->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLocation->getTripLocName(),
                    'tripLocDesc' => $tripLocation->getTripLocDesc(),
                    'tripLatLon' => $tripLocation->getTripLatLon(),
                    'tripLocImg' => $tripLocation->getTripLocImg(),
                    'createdAt' => $tripLocation->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->generateUrl('trip_location_show', [
                        'id' => $tripLocation->getId(),
                    ]),
                ];
            }
        }

        return new JsonResponse($arrayContent);
    }

    /**
     * @Route("location/{id}", name="trip_location_show")
     */
    public function showAction(TripLocation $tripLocation)
    {
        // Get this trip location, return not found if is not public.
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('TriplogBundle:TripLocation')
            ->findOnePublicById($tripLocation->getId());

        if(!$location) {
            throw $this->createNotFoundException('No trip found');
        }

        return $this->render('TriplogBundle:Location:show.html.twig', [
            'location' => $location,
        ]);
    }

}