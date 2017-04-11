<?php


namespace TriplogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TriplogBundle\Entity\TripLocation;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_MANAGE_LOCATION')")
 */
class TripLocationAdminController extends Controller
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

    /**
     * @Route("/location/{id}/edit", name="admin_location_edit")
     */
    public function editAction(Request $request, TripLocation $tripLocation)
    {
        $form = $this->createForm('TriplogBundle\Form\TripLocationFormType', $tripLocation);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            $this->addFlash('success', 'Location updated.');

            return $this->redirectToRoute('admin_trip_locations_list');
        }

        return $this->render('TriplogBundle:Admin/Location:edit.html.twig',[
            'locationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/location/{id}/delete", name="admin_location_delete")
     */
    public function deleteAction(Request $request, TripLocation $tripLocation)
    {
        $form = $this->createForm('TriplogBundle\Form\TripLocationFormType', $tripLocation);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->remove($location);
            $em->flush();

            $this->addFlash('success', 'Location deleted.');

            return $this->redirectToRoute('admin_trip_locations_list');
        }

        return $this->render('TriplogBundle:Admin/Location:delete.html.twig',[
            'locationForm' => $form->createView()
        ]);
    }

}