<?php

namespace TriplogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use TriplogBundle\Entity\TripCategory;
use TriplogBundle\Entity\TripLocation;

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
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('TriplogBundle:TripCategory')
            ->findAllOrderByName();

        // Generate proper data for json.
        $arrayContent['categories'] = [];
        foreach($categories as $index => $category) {
            $arrayContent['categories'][] = [
                'id' => $category->getId(),
                'tripCatName' => $category->getTripCatName(),
                'link' => $this->generateUrl('trip_category_show', [
                    'id' => $category->getId(),
                ]),
            ];
        }

        return new JsonResponse($arrayContent);
    }

    /**
     * @Route("/api/category/{id}", name="api_category_view")
     */
    public function apiShowAction(TripCategory $tripCategory)
    {
        // Get all locations on category.
        $tripLocs = $tripCategory->getTripLocations()
            ->filter(function (TripLocation $tripLocation) {
                return $tripLocation->getIsPublic() == true;
            });

        $arrayContent['locations'] = [];
        if($tripLocs) {
            $index = 0;
            foreach($tripLocs as $tripLoc) {
                // Get Images on this locations.
                $tripLocImages = $tripLoc->getTripLocImg();
                $tripLocImg = [];
                if($tripLocImages) {
                    foreach($tripLocImages as $tripLocImage) {
                        $tripLocImg[] = $tripLocImage->getTripImgUrl();
                    }
                }

                $arrayContent['locations'][] = [
                    'id' => $tripLoc->getId(),
                    'tripCategory' => $tripLoc->getTripCategory()->getTripCatName(),
                    'tripLocName' => $tripLoc->getTripLocName(),
                    'tripLocDesc' => $tripLoc->getTripLocDesc(),
                    'tripLocImg' => $tripLocImg,
                    'tripLatLon' => (!empty($tripLoc->getTripLatLon())) ? explode(",", $tripLoc->getTripLatLon()) : [],
                    'createdAt' => $tripLoc->getCreatedAt()->format("F d Y, H:ma"),
                    'posTimeline' => ($index % 2 == 0) ? 'pos-left clearfix' : 'pos-right clearfix',
                    'link' => $this->generateUrl('trip_location_show', [
                        'id' => $tripLoc->getId(),
                    ]),
                    'linkCat' => $this->generateUrl('trip_category_show', [
                        'id' => $tripLoc->getTripCategory()->getId(),
                    ]),
                ];
                $index++;
            }
        }

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