<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;

use Etsi\SiteBundle\Entity\Contenido,
    Etsi\SiteBundle\Entity\Seccion,
    Etsi\SiteBundle\Form\ContenidoType;


class ContenidosController extends Controller
{

    public function newContenidoAction()
    {
        $data = $this->getForm();
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newContenido.html.twig');
        $view->setFormat('html');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getContenidoAction($id)
    {
        $view = new View();

        $em = $this->getDoctrine()->getManager();
        $contenido = $em->getRepository('EtsiSiteBundle:Contenido')->find($id);

        if (!$contenido) {
            $view->setStatusCode(404);
        } else {
            $view->setStatusCode(302)
                 ->setData($contenido);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function editContenidoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contenido = $em->getRepository('EtsiSiteBundle:Contenido')->find($id);

        $data = $this->getForm($contenido);
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newContenido.html.twig');
        $view->setFormat('html');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function postContenidoAction(Request $request)
    {
        $form = $this->getForm();
        $form->bind($request);

        $view = View::create($form);

        if ($form->isValid()) {
            $data = $form->getData();
            $entity = $this->createContenido($data);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view->setStatusCode(200)
                 ->setData($entity);
        } else {
            $view->setTemplate('EtsiSiteBundle:Form:newContenido.html.twig');
            $view->setFormat('html');
            $view->setStatusCode(406);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    protected function getForm($contenido = null)
    {
        return $this->createForm(new ContenidoType(), $contenido);
    }

    private function createContenido($data)
    {
        $contenido = null;

        if($data['id']) {
            $em = $this->getDoctrine()->getManager();
            $contenido = $em->getRepository('EtsiSiteBundle:Contenido')->find($data['id']);
        }
        
        if(!$contenido)
            $contenido = new Contenido();

        $contenido->setTitulo($data['titulo']);
        $contenido->setImagen($data['imagen']);
        $contenido->setResumen($data['resumen']);
        $contenido->setDescripcion($data['descripcion']);
        $contenido->setFecha($data['fecha']);


        $secciones = $contenido->getSecciones();
        foreach ($secciones as $seccion)
            $contenido->removeSeccion($seccion);

        foreach($data['secciones'] as $seccion)
            $contenido->addSeccion($seccion);


        return $contenido;
    }
}