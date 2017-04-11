<?php


namespace TriplogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TriplogBundle\Form\UserRegistrationForm;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('Success', 'Registration success!');

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess($user, $request , $this->get('trip.login_form_authenticator'), 'main');

        }

        return $this->render('TriplogBundle:User:register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}