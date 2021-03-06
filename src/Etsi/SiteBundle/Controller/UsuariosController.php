<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;

use Etsi\SiteBundle\Entity\Usuario,
    Etsi\SiteBundle\Form\UsuarioType;


class UsuariosController extends Controller
{

    public function newUsuarioAction()
    {
        $data = $this->getForm();
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newUsuario.html.twig');
        $view->setFormat('html');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getUsuarioAction($id)
    {
        $view = new View();

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('EtsiSiteBundle:Usuario')->find($id);

        if (!$usuario) {
            $view->setStatusCode(404);
        } else {
            $view->setStatusCode(302)
                 ->setData($usuario);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function editUsuarioAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('EtsiSiteBundle:Usuario')->find($id);

        $data = $this->getForm($usuario);
        $view = new View($data);
        $view->setTemplate('EtsiSiteBundle:Form:newUsuario.html.twig');
        $view->setFormat('html');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function postUsuarioAction(Request $request)
    {
        $form = $this->getForm();
        $form->bind($request);

        $view = View::create($form);

        if ($form->isValid()) {
            $data = $form->getData();
            $entity = $this->createUsuario($data);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view->setStatusCode(200)
                 ->setData($entity);
        } else {
            $view->setTemplate('EtsiSiteBundle:Form:newUsuario.html.twig');
            $view->setFormat('html');
            $view->setStatusCode(406);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    protected function getForm($usuario = null)
    {
        return $this->createForm(new UsuarioType(), $usuario);
    }

    private function createUsuario($data)
    {
        $usuario = null;

        if($data['id']) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('EtsiSiteBundle:Usuario')->find($data['id']);
        }
        
        if(!$usuario)
            $usuario = new Usuario();

        $usuario->setNick($data['nick']);
        $usuario->setPass($data['pass']);
        $usuario->setImagen($data['imagen']);

        return $usuario;
    }
}