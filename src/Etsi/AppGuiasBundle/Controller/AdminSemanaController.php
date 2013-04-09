<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Semana;

class AdminSemanaController extends Controller
{
    private function renderReturn(
        $action,
        $id = null,
        $messages = array('success' => array(), 'warning' => array(), 'error' => array())
    ) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Semana')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Semana')->find($id):null;

        if(!$messages) {
            $messages = array(
                'success' => array(),
                'warning' => array(),
                'error' => array(),
            );
        }
        return $this->render(
            'EtsiAppGuiasBundle:Admin:semana.html.twig',
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
            'numeroSemana',
            'horasGruposGrandes',
            'horasGruposReducidosAula',
            'horasGruposReducidosInformatica',
            'horasGruposReducidosLaboratorio',
            'horasGruposReducidosCampo',
            'examen',
            'observaciones'
        );

        if(Herramientas::allFields($camposObligatorios, $data)) {
            $entity->setNumeroSemana($data['numeroSemana']);
            $entity->setHorasGruposGrandes($data['horasGruposGrandes']);
            $entity->setHorasGruposReducidosAula($data['horasGruposReducidosAula']);
            $entity->setHorasGruposReducidosInformatica($data['horasGruposReducidosInformatica']);
            $entity->setHorasGruposReducidosLaboratorio($data['horasGruposReducidosLaboratorio']);
            $entity->setHorasGruposReducidosCampo($data['horasGruposReducidosCampo']);
            $entity->setExamen($data['examen']);
            $entity->setObservaciones($data['observaciones']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return true;
        }
        return false;
    }

    public function indexAction()
    {
        return $this->renderReturn($this->generateUrl('eaga_semana_new'));
    }

    public function newAction(Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $entity  = new Semana();
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $messages['success'][] = 'Semana guardada correctamente';
        } else {
            $messages['error'][] = 'Faltan campos obligatorios, semana no guardada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_semana_edit', array('id' => $entity->getId())),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Semana')->find($id);

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
            $this->generateUrl('eaga_semana_edit', array('id' => $id)),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Semana')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();

            $messages['success'][] = 'Semana eliminada correctamente';
        } else {
            $messages['error'][] = 'Entidad no encontrada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_semana_new'),
            null,
            $messages
        );
    }
}
