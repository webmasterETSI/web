<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Guia;

class AdminGuiaController extends Controller
{
    private function renderReturn(
        $action,
        $id = null,
        $messages = array('success' => array(), 'warning' => array(), 'error' => array())
    ) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Guia')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Guia')->find($id):null;

        if(!$messages) {
            $messages = array(
                'success' => array(),
                'warning' => array(),
                'error' => array(),
            );
        }
        return $this->render(
            'EtsiAppGuiasBundle:Admin:guia.html.twig',
            array(
                'action' => $action,
                'messages' => $messages,
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

            return true;
        }
        return false;
    }

    public function indexAction()
    {
        return $this->renderReturn($this->generateUrl('eaga_guia_new'));
    }

    public function newAction(Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $entity  = new Guia();
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $messages['success'][] = 'Guia guardada correctamente';
        } else {
            $messages['error'][] = 'Faltan campos obligatorios, guia no guardada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_guia_edit', array('id' => $entity->getId())),
            $entity->getId(),
            $messages
        );
    }

    public function editAction($id, Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);

        if(!$entity) {
            $messages['error'][] = 'Entidad no encontrada';
        } else {
            if($this->fillEntity($entity, $data)) {
                $messages['success'][] = 'Cambios guardada correctamente';
            } else {
                if(isset($data['nombre']))
                    $messages['error'][] = 'Faltan campos obligatorios, cambios no guardada';
            }
        }
        
        return $this->renderReturn(
            $this->generateUrl('eaga_guia_edit', array('id' => $id)),
            $id,
            $messages
        );
    }

    public function deleteAction($id)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();

            $messages['success'][] = 'Guia eliminada correctamente';
        } else {
            $messages['error'][] = 'Entidad no encontrada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_guia_new'),
            null,
            $messages
        );
    }
}
