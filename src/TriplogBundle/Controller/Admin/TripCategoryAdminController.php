<?php


namespace TriplogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
            ->findAllOrderByName();

        return $this->render('TriplogBundle:Admin:category.index.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/new", name="admin_category_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('TriplogBundle\Form\TripCategoryFormType');

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Category created.');

            return $this->redirectToRoute('admin_trip_categories_list');
        }

        return $this->render('TriplogBundle:Admin/Category:new.html.twig',[
            'categoryForm' => $form->createView()
        ]);
    }
}