<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Asignatura,
    Etsi\AppGuiasBundle\Entity\Area,
    Etsi\AppGuiasBundle\Entity\Grado;

class AdminAsignaturaController extends Controller
{
    private function renderReturn(
        $action,
        $id = null,
        $messages = array('success' => array(), 'warning' => array(), 'error' => array())
    ) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->findAll();
        $grados = $em->getRepository('EtsiAppGuiasBundle:Grado')->findAll();
        $areas = $em->getRepository('EtsiAppGuiasBundle:Area')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id):null;

        if(!$messages) {
            $messages = array(
                'success' => array(),
                'warning' => array(),
                'error' => array(),
            );
        }
        return $this->render(
            'EtsiAppGuiasBundle:Admin:asignatura.html.twig',
            array(
                'action' => $action,
                'messages' => $messages,
                'entities' => $entities,
                'grados' => $grados,
                'areas' => $areas,
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
            'curso'
        );

        if(Herramientas::allFields($camposObligatorios, $data)) {
            $em = $this->getDoctrine()->getManager();

            $entity->setNombre($data['nombre']);
            $entity->setNombreI($data['nombreI']);
            $entity->setCodigo($data['codigo']);
            $entity->setCaracter($data['caracter']);
            $entity->setCreditos($data['creditos']);
            $entity->setCurso($data['curso']);
            $entity->setCuatrimestre($data['cuatrimestre']);

            $entity->clearGrados();
            if(isset($data['grados']) && !empty($data['grados'])) {
                foreach($data['grados'] as $value) {
                    $grado = $em->getRepository('EtsiAppGuiasBundle:Grado')->find($value);
                    $entity->addGrado($grado);
                }
            }

            $entity->clearAreas();
            if(isset($data['areas']) && !empty($data['areas'])) {
                foreach($data['areas'] as $value) {
                    $area = $em->getRepository('EtsiAppGuiasBundle:Area')->find($value);
                    $entity->addArea($area);
                }
            }

            $em->persist($entity);
            $em->flush();

            return true;
        }
        return false;
    }

    public function indexAction()
    {
        return $this->renderReturn($this->generateUrl('eaga_asignatura_new'));
    }

    public function newAction(Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $entity  = new Asignatura();
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $messages['success'][] = 'Asignatura guardada correctamente';
        } else {
            $messages['error'][] = 'Faltan campos obligatorios, asignatura no guardada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_asignatura_edit', array('id' => $entity->getId())),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);

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
            $this->generateUrl('eaga_asignatura_edit', array('id' => $id)),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();

            $messages['success'][] = 'Asignatura eliminada correctamente';
        } else {
            $messages['error'][] = 'Entidad no encontrada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_asignatura_new'),
            null,
            $messages
        );
    }
}
