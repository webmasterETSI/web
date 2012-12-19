<?php

namespace Etsi\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function homeAction()
    {
        return $this->render(
            'EtsiSiteBundle:Default:bloque_layout.html.twig',
            array(
                'menuTop' => array(
                    array('titulo' => 'prueba0', 'href' => 'http://www.google.com'),
                    array('titulo' => 'prueba1', 'href' => 'http://www.facebook.com'),
                    array('titulo' => 'prueba2', 'href' => 'http://www.twitter.com'),
                ),
                'menuImg' => array(
                    array('imagen' => '../images/prueba.png', 'href' => 'http://www.google.com'),
                    array('imagen' => '../images/prueba.png', 'href' => 'http://www.twitter.com'),
                ),
                'menuIzq' => array(
                    array('titulo' => 'prueba0', 'href' => 'http://www.google.com'),
                    array('titulo' => 'prueba2', 'href' => 'http://www.twitter.com'),
                ),
                'noticias' => array(
                    array('titulo' => 'prueba0', 'descripcion' => 'Prueba de descripcion', 'fecha' => '12/12/12'),
                ),
            )
        );
    }


    public function contenidoAction($slug)
    {
        return $this->render(
            'EtsiSiteBundle:Default:contenido_layout.html.twig',
            array(
                'titulo' => 'test',
                'contenido' => 'test de contenido',
                'menuTop' => array(
                    array('titulo' => 'prueba0', 'href' => 'http://www.google.com'),
                    array('titulo' => 'prueba1', 'href' => 'http://www.facebook.com'),
                    array('titulo' => 'prueba2', 'href' => 'http://www.twitter.com'),
                ),
                'menuDer' => array(
                    array('titulo' => 'prueba0', 'href' => 'http://www.google.com'),
                    array(
                        'titulo' => 'prueba1',
                        'children' => array(
                            array('titulo' => 'item submenu', 'href' => 'http://www.google.com'),
                        )
                    ),
                    array('titulo' => 'prueba2', 'href' => 'http://www.twitter.com'),
                ),
            )
        );
    }
}
