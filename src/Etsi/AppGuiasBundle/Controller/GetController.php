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

    public function searchAsignaturaAction($q)
    {
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Asignatura');

        $query = $repositorio->createQueryBuilder('a')
            ->where('a.nombre LIKE :nombre')
            ->setParameter('nombre', '%'.$q.'%')
            ->getQuery();

        $entitiesNombre = $query->getResult();
        $entitiesCodigo = $repositorio->findByCodigo($q);

        $entities = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($entitiesNombre as $value)
            $entities->add($value);
        foreach($entitiesCodigo as $value)
            $entities->add($value);

        return $this->jsonResponse($entities);
    }

    public function searchProfesorAction($q)
    {
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Profesor');

        $query = $repositorio->createQueryBuilder('p')
            ->where('p.nombre LIKE :nombre')
            ->setParameter('nombre', '%'.$q.'%')
            ->getQuery();
        $entitiesNombre = $query->getResult();

        $query = $repositorio->createQueryBuilder('p')
            ->where('p.email LIKE :email')
            ->setParameter('email', $q.'%')
            ->getQuery();
        $entitiesEmail = $query->getResult();

        $entities = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($entitiesNombre as $value)
            $entities->add($value);
        foreach($entitiesEmail as $value)
            $entities->add($value);

        return $this->jsonResponse($entitiesNombre);
    }

    public function searchCompetenciaAction($q)
    {
        $repositorio = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EtsiAppGuiasBundle:Competencia');

        $query = $repositorio->createQueryBuilder('c')
            ->where('c.nombre LIKE :nombre')
            ->setParameter('nombre', '%'.$q.'%')
            ->getQuery();

        $entitiesNombre = $query->getResult();
        $entitiesCodigo = $repositorio->findByCodigo($q);

        $entities = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($entitiesNombre as $value)
            $entities->add($value);
        foreach($entitiesCodigo as $value)
            $entities->add($value);
        
        return $this->jsonResponse($entities);
    }
}
