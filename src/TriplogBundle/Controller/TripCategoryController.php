<?php

namespace TriplogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use TriplogBundle\Entity\TripCategory;


class TripCategoryController extends Controller
{
    /**
     * @Route("/categories", name="trip_categories")
     */
    public function indexAction()
    {
        return $this->render('TriplogBundle:Category:list.html.twig');
    }

    /**
     * @Route("/api/category/list", name="api_category_list")
     */
    public function apiListAction()
    {
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $arrayContent = $tripData->TripRenderCategoriesData();

        return new JsonResponse($arrayContent);
    }

    /**
     * @Route("/api/category/{id}", name="api_category_view")
     */
    public function apiShowAction(TripCategory $tripCategory)
    {
        // Call TripDataRenderer service.
        $tripData = $this->get('trip.data_renderer');
        $arrayContent = $tripData->TripRenderLocationCategory($tripCategory);

        return new JsonResponse($arrayContent);

    }

    /**
     * @Route("/category/{id}", name="trip_category_show")
     */
    public function showAction(TripCategory $tripCategory)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('TriplogBundle:TripCategory')
            ->findOneBy(['id' => $tripCategory->getId()]);

        if(!$category) {
            throw $this->createNotFoundException('No category found.');
        }


        return $this->render('TriplogBundle:Category:show.html.twig',[
            'category' => $category,
        ]);
    }

}