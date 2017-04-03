<?php


namespace TriplogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            ->findAllOrderByDate();

        return $this->render('TriplogBundle:Admin:trip.index.html.twig',[
            'trips' => $trips
        ]);
    }

    /**
     * @Route("/trip/new", name="admin_trip_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('TriplogBundle\Form\TripFormType');

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $trip = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($trip);
            $em->flush();

            $this->addFlash('success', 'Trip created.');

            return $this->redirectToRoute('admin_trip_list');
        }

        return $this->render('TriplogBundle:Admin/Trip:new.html.twig',[
            'tripForm' => $form->createView()
        ]);
    }
}