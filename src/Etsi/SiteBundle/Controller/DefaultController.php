<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;

use Etsi\SiteBundle\Form\UsuarioType,
    Etsi\SiteBundle\Form\SeccionType,
    Etsi\SiteBundle\Form\ContenidoType;


class DefaultController extends Controller
{
    public function indexAction()
    {
        /*
        $data = $this->createForm(new UsuarioType());
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newUsuario.html.twig');
        */
        /*
        $data = $this->createForm(new ContenidoType());
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newContenido.html.twig');
        return $this->get('fos_rest.view_handler')->handle($view);
        */
        $data = $this->createForm(new SeccionType());
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newSeccion.html.twig');
        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
