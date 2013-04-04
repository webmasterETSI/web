<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Asignatura;

class AdminAsignaturaController extends Controller
{
    private function renderReturn($action, $id = null) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id):null;

        return $this->render(
            'EtsiAppGuiasBundle:Admin:asignatura.html.twig',
            array(
                'action' => $action,
                'entities' => $entities,
                'entity' => $entity,
            )
        );
    }

    private function fillEntity($entity, $data) {
        $camposObligatorios = array(
            'nombre',
            'nombreI',
            'codigo',
            'caracter',
            'creditos',
            'departamento',
            'area',
            'curso',
            'cuatrimestre'
        );

        if(Herramientas::allFields($camposObligatorios, $data)) {
            $entity->setNombre($data['nombre']);
            $entity->setNombreI($data['nombreI']);
            $entity->setCodigo($data['codigo']);
            $entity->setCaracter($data['caracter']);
            $entity->setCreditos($data['creditos']);
            $entity->setDepartamento($data['departamento']);
            $entity->setArea($data['area']);
            $entity->setCurso($data['curso']);
            $entity->setCuatrimestre($data['cuatrimestre']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    public function indexAction()
    {
        return $this->renderReturn($this->generateUrl('eaga_asignatura_new'));
    }

    public function newAction(Request $request)
    {
        $entity  = new Asignatura();
        $data = $request->request->all();

        $this->fillEntity($entity, $data);

        return $this->renderReturn(
            $this->generateUrl('eaga_asignatura_edit', array('id' => $entity->getId())),
            $entity->getId()
        );
    }

    public function editAction($id, Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);
        
        $this->fillEntity($entity, $data);
        
        return $this->renderReturn(
            $this->generateUrl('eaga_asignatura_edit', array('id' => $id)),
            $id
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->renderReturn($this->generateUrl('eaga_asignatura_new'));
    }
}
