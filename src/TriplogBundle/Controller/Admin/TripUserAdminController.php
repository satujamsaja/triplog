<?php

namespace TriplogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_MANAGE_USER')")
 */
class TripUserAdminController extends Controller
{
    /**
     * @Route("/users", name="admin_trip_user_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TriplogBundle:User')
            ->findAll();

        return $this->render('TriplogBundle:Admin:user.index.html.twig',[
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/new", name="admin_trip_user_new")
     */
    public function newAction()
    {
        return $this->render('TriplogBundle:Admin/User:new.html.twig');
    }
}