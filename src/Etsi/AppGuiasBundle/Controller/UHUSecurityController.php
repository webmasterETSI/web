<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Rol;

class UHUSecurityController extends Controller
{
    private function logUser(UserInterface $user, $password) {
        $token = new UsernamePasswordToken($user, $password, 'secured_area', $user->getRoles());
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->set('_security_secured_area',  serialize($token));
    }

    private function validaUsuario($usuario, $password) {
        $url = 'http://uhu.es/etsi/appGuias/pasarela.php';
        $fields = array(
            '_username' => urlencode($usuario),
            '_password' => urlencode($password)
        );

        $fieldsString = '';
        foreach($fields as $key=>$value)
            $fieldsString .= $key.'='.$value.'&';
        rtrim($fieldsString, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function loginAction(Request $request)
    {
        $data = $request->request->all();
        $mensajes = array();
        if( isset($data['_username']) && !empty($data['_username']) && isset($data['_password']) && !empty($data['_password']) ) {
            if($this->validaUsuario($data['_username'], $data['_password']) == '1') {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findOneByEmail($data['_username']);

                if($entity) {
                    $passUsado = $encoder->encodePassword($data['_password'], $entity->getSalt());
                    if($passUsado != $entity->getPassword()) {
                        $entity->setSalt(md5(time()));
                        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
                        $password = $encoder->encodePassword($data['password'], $entity->getSalt());
                        $entity->setPassword($password);
                    }
                }
                else {
                    $rol = $em->getRepository('EtsiAppGuiasBundle:Rol')->findOneByName('ROLE_PROFESOR');

                    $entity  = new Profesor();
                    $entity->addRole($rol);                    
                    $entity->setNombre('');
                    $entity->setEmail($data['_username']);
                    $entity->setTlf('');
                    
                    $entity->setSalt(md5(time()));
                    $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
                    $password = $encoder->encodePassword($data['_password'], $entity->getSalt());
                    $entity->setPassword($password);

                    $em->persist($entity);
                    $em->flush();
                }

                $this->logUser($entity, $data['_password']);

                return $this->redirect($this->generateUrl('etsi_app_guia_guia'));
            }
            else $mensajes['error'] = array('Datos incorrectos');
        }

        return $this->render('EtsiAppGuiasBundle::login.html.twig', array(
            'last_username' => isset($data['_username'])?$data['_username']:'',
            'messages'      => $mensajes,
        ));
    }
}