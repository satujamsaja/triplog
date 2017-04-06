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
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $arrayContent = $tripData->TripRenderLocationData();

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
            throw $this->createNotFoundException('No location found');
        }

        return $this->render('TriplogBundle:Location:show.html.twig', [
            'location' => $location,
        ]);
    }

}