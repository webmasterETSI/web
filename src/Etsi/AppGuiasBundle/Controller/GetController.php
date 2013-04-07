<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Etsi\AppGuiasBundle\Entity\Asignatura,
    Etsi\AppGuiasBundle\Entity\Competencia,
    Etsi\AppGuiasBundle\Entity\Grado,
    Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Semana;

class GetController extends Controller
{
    public function jsonResponse($entidad, $id)
    {
        $response = new Response();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($entidad)->find($id);

        if ($entity) {
            $serializer = $this->get('jms_serializer');

            $response->setStatusCode('200');
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($serializer->serialize($entity, 'json'));
        } else {
            $response->setStatusCode('400');
        }

        return $response;
    }

    public function getAsignaturaAction($id)
    {
        return $this->jsonResponse('EtsiAppGuiasBundle:Asignatura', $id);
    }

    public function getProfesorAction($id)
    {
        return $this->jsonResponse('EtsiAppGuiasBundle:Profesor', $id);
    }

    public function getCompetenciaAction($id)
    {
        return $this->jsonResponse('EtsiAppGuiasBundle:Competencia', $id);
    }

    public function getSemanaAction($id)
    {
        return $this->jsonResponse('EtsiAppGuiasBundle:Semana', $id);
    }
}
