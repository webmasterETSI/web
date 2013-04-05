<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EtsiAppGuiasBundle::frontLayout.html.twig');
    }

    public function demoAction()
    {
        return $this->render('EtsiAppGuiasBundle::adminTemplateLayout.html.twig');
    }
}
