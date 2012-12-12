<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;

use Etsi\SiteBundle\Entity\Contenido,
    Etsi\SiteBundle\Form\ContenidoType;


class ContenidosController extends Controller
{
    public function getContenidoAction($id)
    {
        $view = new View();

        $em = $this->getDoctrine()->getManager();

        $contenido = $em->getRepository('EtsiSiteBundle:Contenido')->find($id);

        if (!$contenido) {
            $view->setStatusCode(400);
        } else {
            $view->setStatusCode(200)
                 ->setData($contenido);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function newContenidoAction()
    {
        $data = $this->getForm();
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newContenido.html.twig');
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
            $view->setStatusCode(400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    protected function getForm($contenido = null)
    {
        return $this->createForm(new ContenidoType(), $contenido);
    }

    private function createContenido($data)
    {
        $contenido = new Contenido();

        $contenido->setTitulo($data['titulo']);
        $contenido->setDescripcion($data['descripcion']);
        $contenido->setImagen($data['imagen']);

        $contenido->setFecha($data['fecha']);

        return $contenido;
    }
}