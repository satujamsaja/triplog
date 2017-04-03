<?php


namespace TriplogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class TripCategoryAdminController extends Controller
{
    /**
     * @Route("/categories", name="admin_trip_categories_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('TriplogBundle:TripCategory')
            ->findAll();

        return $this->render('TriplogBundle:Admin:category.index.html.twig',[
            'categories' => $categories
        ]);
    }
}