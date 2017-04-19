<?php

namespace TriplogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use TriplogBundle\Entity\User;


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
    public function newAction(Request $request)
    {
        $form = $this->createForm('TriplogBundle\Form\UserFormType');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('Success', 'User created');

            return $this->redirectToRoute('admin_trip_user_list');

        }

        return $this->render('TriplogBundle:Admin/User:new.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="admin_trip_user_edit")
     */
    public function editAction(Request $request, User $user)
    {
        $file = new File($this->getParameter('image_directory') . '/' . $user->getProfilePicture());

        $user->setProfilePicture($file);

        $form = $this->createForm('TriplogBundle\Form\UserFormType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('Success', 'User updated');

            return $this->redirectToRoute('admin_trip_user_list');

        }

        return $this->render('TriplogBundle:Admin/User:edit.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}