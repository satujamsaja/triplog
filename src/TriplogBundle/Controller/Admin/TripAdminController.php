<?php


namespace TriplogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 *@Route("/admin")
 */
class TripAdminController extends Controller
{
    /**
     * @Route("/trips", name="admin_trip_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('TriplogBundle:Trip')
            ->findAll();

        return $this->render('TriplogBundle:Admin:trip.index.html.twig',[
            'trips' => $trips
        ]);
    }
}