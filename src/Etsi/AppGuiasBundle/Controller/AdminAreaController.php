<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Area;

class AdminAreaController extends Controller
{
    private function renderReturn(
        $action,
        $id = null,
        $messages = array('success' => array(), 'warning' => array(), 'error' => array())
    ) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Area')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Area')->find($id):null;

        if(!$messages) {
            $messages = array(
                'success' => array(),
                'warning' => array(),
                'error' => array(),
            );
        }
        return $this->render(
            'EtsiAppGuiasBundle:Admin:area.html.twig',
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
            'departamento'
        );

        if(Herramientas::allFields($camposObligatorios, $data)) {
            $em = $this->getDoctrine()->getManager();

            $entity->setNombre($data['nombre']);
            $entity->setDepartamento($data['departamento']);

            $em->persist($entity);
            $em->flush();

            return true;
        }
        return false;
    }

    public function indexAction()
    {
        return $this->renderReturn($this->generateUrl('eaga_area_new'));
    }

    public function newAction(Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $entity  = new Area();
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $messages['success'][] = 'Area guardada correctamente';
        } else {
            $messages['error'][] = 'Faltan campos obligatorios, area no guardada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_area_edit', array('id' => $entity->getId())),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Area')->find($id);

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
            $this->generateUrl('eaga_area_edit', array('id' => $id)),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Area')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();

            $messages['success'][] = 'Area eliminada correctamente';
        } else {
            $messages['error'][] = 'Entidad no encontrada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_area_new'),
            null,
            $messages
        );
    }
}
