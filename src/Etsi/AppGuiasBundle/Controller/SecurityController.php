<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Rol;
/**
 * Security controller.
 *
 * @Route("/admin")
 */
class SecurityController extends Controller
{
    /**
     * Definimos las rutas para el login:
     * @Route("/login", name="login")
     * @Route("/login_check", name="login_check")
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $messages = $error?array('error' => array($error)):array();
        
        return $this->render('EtsiAppGuiasBundle::login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'messages'      => $messages,
        ));
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

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rol = $em->getRepository('EtsiAppGuiasBundle:Rol')->findOneByName('ROLE_PROFESOR');

        $entity  = new Profesor();
        $entity->addRole($rol);
        $data = $request->request->all();

        if($this->fillEntity($entity, $data)) {
            $token = new UsernamePasswordToken($entity, $data['password'], 'secured_area', array('ROLE_PROFESOR'));
            $request = $this->getRequest();
            $session = $request->getSession();
            $session->set('_security_secured_area',  serialize($token));

            return $this->redirect($this->generateUrl('etsi_app_guia_guia'));
        }


        return $this->render(
            'EtsiAppGuiasBundle::login.html.twig',
            array(
                'messages' => array(
                    'error' => array('Faltan campos obligatorios, cuenta no creada')
                )
            )
        );
    }
}