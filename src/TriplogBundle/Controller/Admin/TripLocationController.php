<?php


namespace TriplogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class TripLocationController extends Controller
{
    /**
     * @Route("/locations", name="admin_trip_locations_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('TriplogBundle:TripLocation')
            ->findAll();

        return $this->render('TriplogBundle:Admin:location.index.html.twig',[
            'locations' => $locations
        ]);
    }

}