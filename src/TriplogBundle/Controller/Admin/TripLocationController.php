<?php


namespace TriplogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            ->findAllOrderByDate();

        return $this->render('TriplogBundle:Admin:location.index.html.twig',[
            'locations' => $locations
        ]);
    }

    /**
     * @Route("/location/new", name="admin_location_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('TriplogBundle\Form\TripLocationFormType');

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            $this->addFlash('success', 'Location created.');

            return $this->redirectToRoute('admin_trip_locations_list');
        }

        return $this->render('TriplogBundle:Admin/Location:new.html.twig',[
            'locationForm' => $form->createView()
        ]);
    }

}