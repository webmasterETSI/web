<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Etsi\AppGuiasBundle\Entity\Asignatura,
    Etsi\AppGuiasBundle\Entity\Competencia,
    Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Semana;

class GetController extends Controller
{
    public function jsonResponse($data)
    {
        $response = new Response();

        if ($data) {
            $serializer = $this->get('jms_serializer');

            $response->setStatusCode('200');
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($serializer->serialize($data, 'json'));
        } else {
            $response->setStatusCode('400');
        }

        return $response;
    }

    public function getAsignaturaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);
        return $this->jsonResponse($entity);
    }

    public function getProfesorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Profesor')->find($id);
        return $this->jsonResponse($entity);
    }

    public function getCompetenciaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Competencia')->find($id);
        return $this->jsonResponse($entity);
    }

    public function getSemanasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('EtsiAppGuiasBundle:Semana')->findByGuia($id);
        return $this->jsonResponse($entities);
    }

    public function searchAsignaturaAction(Request $request)
    {
        $datos = json_decode($request->getContent());
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Asignatura');

        switch($datos->key) {
            case 'nombre':
                $query = $repositorio->createQueryBuilder('a')
                    ->where('a.nombre LIKE :nombre')
                    ->setParameter('nombre', '%'.$datos->value.'%')
                    ->getQuery();

                $entities = $query->getResult();
                break;

            case 'codigo':
                $entities = $repositorio->findByCodigo($datos->value);
                break;
        }

        return $this->jsonResponse($entities);
    }

    public function searchProfesorAction(Request $request)
    {
        $datos = json_decode($request->getContent());
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Profesor');

        switch($datos->key) {
            case 'nombre':
                $query = $repositorio->createQueryBuilder('p')
                    ->where('p.nombre LIKE :nombre')
                    ->setParameter('nombre', '%'.$datos->value.'%')
                    ->getQuery();

                $entities = $query->getResult();
                break;

            case 'email':
                $query = $repositorio->createQueryBuilder('p')
                    ->where('p.email LIKE :email')
                    ->setParameter('email', $datos->value.'%')
                    ->getQuery();

                $entities = $query->getResult();
                break;
        }

        return $this->jsonResponse($entities);
    }

    public function searchCompetenciaAction(Request $request)
    {
        $datos = json_decode($request->getContent());
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Competencia');

        switch($datos->key) {
            case 'nombre':
                $query = $repositorio->createQueryBuilder('c')
                    ->where('c.nombre LIKE :nombre')
                    ->setParameter('nombre', '%'.$datos->value.'%')
                    ->getQuery();

                $entities = $query->getResult();
                break;

            case 'codigo':
                $entities = $repositorio->findByCodigo($datos->value);
                break;
        }

        return $this->jsonResponse($entities);
    }
}
