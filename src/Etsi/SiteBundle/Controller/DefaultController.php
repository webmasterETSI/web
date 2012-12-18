<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EtsiSiteBundle:Default:index.html.twig');
    }
}
