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
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $tripDataContent = $tripData->TripRenderData();

        return new JsonResponse($tripDataContent);
    }

    /**
     * @Route("/api/trip/map", name="api_trip_map")
     */
    public function apiMapAction()
    {
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $arrayContent = $tripData->TripRenderMap();

        return new JsonResponse($arrayContent);
    }

    /**
     * @Route("/api/trip/{id}", name="api_trip_view")
     */
    public function apiShowAction(Trip $trip)
    {
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $arrayContent = $tripData->TripRenderLocation($trip);

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
            throw $this->createNotFoundException('No trip found.');
        }

        return $this->render('TriplogBundle:Trip:show.html.twig', [
            'trip' => $trip,
        ]);
    }

    /**
     * @Route("/maps", name="trips_map")
     */
    public function mapShowAction()
    {
        return $this->render('@Triplog/Trip/map.show.html.twig');
    }

}