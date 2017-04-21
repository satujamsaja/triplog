<?php


namespace TriplogBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TriplogBundle\Entity\TripCategory;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_MANAGE_CATEGORY')")
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

            $file = $category->getTripCatImage();
            $fileName = $this->get('trip.file_uploader')->upload($file);
            $category->setTripCatImage($fileName);

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

    /**
     * @Route("/category/{id}/edit", name="admin_category_edit")
     */
    public function editAction(Request $request, TripCategory $tripCategory)
    {
        $form = $this->createForm('TriplogBundle\Form\TripCategoryFormType', $tripCategory);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Category updated.');

            return $this->redirectToRoute('admin_trip_categories_list');
        }

        return $this->render('TriplogBundle:Admin/Category:edit.html.twig',[
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/{id}/delete", name="admin_category_delete")
     */
    public function deleteAction(Request $request, TripCategory $tripCategory)
    {
        $form = $this->createForm('TriplogBundle\Form\TripCategoryFormType', $tripCategory);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            $this->addFlash('success', 'Category deleted.');

            return $this->redirectToRoute('admin_trip_categories_list');
        }

        return $this->render('TriplogBundle:Admin/Category:delete.html.twig',[
            'categoryForm' => $form->createView()
        ]);
    }
}