<?php

namespace TriplogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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