<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Guia;

class AdminGuiaController extends Controller
{
    private function renderReturn( $messages = array('success' => array(), 'warning' => array(), 'error' => array()) ) {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('EtsiAppGuiasBundle:Guia')->findAll();

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
                'messages' => $messages,
                'entities' => $entities,
            )
        );
    }

    public function indexAction()
    {
        return $this->renderReturn();
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

        return $this->renderReturn($messages);
    }
}
