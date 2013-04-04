<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class AdminAsignaturaController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->findAll();

        return $this->render(
            'EtsiAppGuiasBundle:AdminAsignatura:list.html.twig',
            array('entities' => $entities)
        );
    }

    public function newAction()
    {
        return new Response("Admin Asignatura: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Asignatura: Editar");
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha podido encontrar al entidad Asignatura.');
        }

        return $this->render(
            'EtsiAppGuiasBundle:AdminAsignatura:show.html.twig',
            array('entity' => $entity)
        );
    }
}
