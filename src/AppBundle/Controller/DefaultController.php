<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/admin", name="homepage_admin")
     */
    public function indexAdminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/adminIndex.html.twig', [

        ]);
    }

    /**
     * @Route("/registration/type", name="registration_type")
     */
    public function registrationTypeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/registration.html.twig', [

        ]);
    }
}
