<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Rol;

class AdminProfesorController extends Controller
{
    private function renderReturn(
        $action,
        $id = null,
        $messages = array('success' => array(), 'warning' => array(), 'error' => array())
    ) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findAll();
        $roles = $em->getRepository('EtsiAppGuiasBundle:Rol')->findAll();
        $entity = $id?$em->getRepository('EtsiAppGuiasBundle:Profesor')->find($id):null;

        if(!$messages) {
            $messages = array(
                'success' => array(),
                'warning' => array(),
                'error' => array(),
            );
        }
        return $this->render(
            'EtsiAppGuiasBundle:Admin:profesor.html.twig',
            array(
                'action' => $action,
                'messages' => $messages,
                'entities' => $entities,
                'entity' => $entity,
                'roles' => $roles,
            )
        );
    }

    private function fillEntity($entity, $data) {
        $camposObligatorios = array(
            'nombre',
            'email',
            'password',
            'tlf'
        );

        if(Herramientas::allFields($camposObligatorios, $data)) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setNombre($data['nombre']);
            $entity->setEmail($data['email']);
            $entity->setTlf($data['tlf']);
            
            if($data['password'] != $entity->getPassword()) {
                $entity->setSalt(md5(time()));
                $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
                $password = $encoder->encodePassword($data['password'], $entity->getSalt());
                $entity->setPassword($password);
            }


            $entity->clearRoles();
            if(isset($data['roles']) && !empty($data['roles'])) {
                foreach($data['roles'] as $value) {
                    $rol = $em->getRepository('EtsiAppGuiasBundle:Rol')->find($value);
                    $entity->addRole($rol);
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
        return $this->renderReturn($this->generateUrl('eaga_profesor_new'));
    }

    public function newAction(Request $request)
    {
        $messages = array(
            'success' => array(),
            'warning' => array(),
            'error' => array(),
        );

        $entity  = new Profesor();
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $messages['success'][] = 'Profesor guardada correctamente';
        } else {
            $messages['error'][] = 'Faltan campos obligatorios, profesor no guardada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_profesor_edit', array('id' => $entity->getId())),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Profesor')->find($id);

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
            $this->generateUrl('eaga_profesor_edit', array('id' => $id)),
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
        $entity = $em->getRepository('EtsiAppGuiasBundle:Profesor')->find($id);

        if($entity) {
            $em->remove($entity);
            $em->flush();

            $messages['success'][] = 'Profesor eliminada correctamente';
        } else {
            $messages['error'][] = 'Entidad no encontrada';
        }

        return $this->renderReturn(
            $this->generateUrl('eaga_profesor_new'),
            null,
            $messages
        );
    }
}
