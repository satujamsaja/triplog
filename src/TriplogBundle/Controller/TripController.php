<?php

namespace TriplogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use TriplogBundle\Entity\Trip;
use TriplogBundle\Entity\TripCategory;
use TriplogBundle\Entity\TripLocation;


class TripController extends Controller
{
    /**
     * @Route("/trips", name="trip_list")
     */
    public function indexAction()
    {
//        $text = 'cache test';
//        $cache = $this->get('doctrine_cache.providers.trip_cache');
//        $key = md5($text);
//
//        if ($cache->contains($key)) {
//            $text = $cache->fetch($text);
//        }
//        else {
//            sleep(1);
//            $text = 'cache test';
//            $cache->save($key, $text);
//        }

        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('TriplogBundle:Trip')
            ->findAllPublicOrderByDate();

        return $this->render('TriplogBundle:Trip:list.html.twig', [
            'trips' => $trips,
        ]);
    }

    /**
     * @Route("/api/trip/list", name="api_trip_list")
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('TriplogBundle:Trip')
            ->findAllPublicOrderByDate();

        // Generate proper trips data for json.
        $arrayContent['trips'] = [];
        foreach($trips as $index => $trip) {
            $arrayContent['trips'][] = array(
                'id' => $trip->getId(),
                'tripName' => $trip->getTripName(),
                'tripDesc' => $trip->getTripDesc(),
                'createdAt' => $trip->getCreatedAt()->format("M d, Y"),
                'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                'link' => $this->generateUrl('trip_show', [
                    'id' => $trip->getId()
                ]),
            );
        }

        $jsonContent = json_encode($arrayContent);

        $response = new Response();
        $response->setContent($jsonContent);
        $response->headers->set('content-type', 'application/json');

        return $response;
    }

    /**
     * @Route("/trip/new", name="trip_new")
     */
    public function newAction()
    {
        $trip = new Trip();
        $trip->setTripName('Trip' . rand(1,100));
        $trip->setTripDesc('Trip desc' . rand(1,100));
        $trip->setCreatedAt(new \DateTime('-' . rand(0,100) . ' days'));
        $trip->setIsPublic(true);

        $tripCategory = new TripCategory();
        $tripCategory->setTripCatName('Cat ' . rand(1,10));
        $tripCategory->setCreatedAt(new \DateTime('-' . rand(0,100) . ' days'));

        $tripLocation = new TripLocation();
        $tripLocation->setTripLocName('Location ' . rand(1,10));
        $tripLocation->setTripLocDesc('Loc desc ' . rand(1,10));
        $tripLocation->setCreatedAt(new \DateTime('-' . rand(0,100) . ' days'));
        $tripLocation->setTripLatLon('-8.670458, 115.212629');
        $tripLocation->setTrip($trip);
        $tripLocation->setTripCategory($tripCategory);
        $tripLocation->setIsPublic(true);


        $em = $this->getDoctrine()->getManager();
        $em->persist($trip);
        $em->persist($tripCategory);
        $em->persist($tripLocation);
        $em->flush();

        return new Response('Trip created');
    }

    /**
     * @Route("/trip/{id}", name="trip_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('TriplogBundle:Trip')
            ->findOnePublicById($id);

        if(!$trip) {
            throw $this->createNotFoundException('No trip found');
        }

        return $this->render('TriplogBundle:Trip:show.html.twig', [
            'trip' => $trip
        ]);
    }

}