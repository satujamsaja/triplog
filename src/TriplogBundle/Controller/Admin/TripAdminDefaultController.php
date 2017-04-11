<?php

namespace TriplogBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Security("is_granted('ROLE_MANAGE_CONTENT')")
 *
 */
class TripAdminDefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function indexAction()
    {
        return $this->render('TriplogBundle:Admin:index.html.twig');
    }
}