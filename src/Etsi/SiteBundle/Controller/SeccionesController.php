<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;

use Etsi\SiteBundle\Entity\Seccion,
    Etsi\SiteBundle\Form\SeccionType;


class SeccionesController extends Controller
{
    public function getSeccionAction($id)
    {
        $view = new View();

        $em = $this->getDoctrine()->getManager();

        $seccion = $em->getRepository('EtsiSiteBundle:Seccion')->find($id);

        if (!$seccion) {
            $view->setStatusCode(400);
        } else {
            $view->setStatusCode(200)
                 ->setData($seccion);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function newSeccionAction()
    {
        $data = $this->getForm();
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newSeccion.html.twig');
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function postSeccionAction(Request $request)
    {
        $form = $this->getForm();
        $form->bind($request);

        $view = View::create($form);

        if ($form->isValid()) {
            $data = $form->getData();
            $entity = $this->createSeccion($data);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view->setStatusCode(200)
                 ->setData($entity);
        } else {
            $view->setTemplate('EtsiSiteBundle:Form:newSeccion.html.twig');
            $view->setStatusCode(400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    protected function getForm($seccion = null)
    {
        return $this->createForm(new SeccionType(), $seccion);
    }

    private function createSeccion($data)
    {
        $seccion = new Seccion();

        $seccion->setTitulo($data['titulo']);
        $seccion->setDescripcion($data['descripcion']);
        $seccion->setImagen($data['imagen']);

        return $seccion;
    }
}