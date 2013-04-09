<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Grado;

class GuiaController extends Controller
{
    private function tipoDeCampo($nombre)
    {
        $campos = array(
            'creditosTeoricos', 
            'creditosPracticosAula',
            'creditosPracticosInformatica',
            'creditosPracticosLaboratorio',
            'creditosPracticosCampo',
            'estado',
            'fechaDeModificacion',
            'curso',
            'datosEspecificos_1_1',
            'datosEspecificos_1_2',
            'datosEspecificos_2_1',
            'datosEspecificos_2_2',
            'datosEspecificos_3',
            'datosEspecificos_6_1_1',
            'datosEspecificos_6_1_2',
            'datosEspecificos_6_2',
            'datosEspecificos_7',
            'datosEspecificos_8_1',
            'datosEspecificos_8_2',
            'datosEspecificos_9_1_1',
            'datosEspecificos_9_1_2',
            'datosEspecificos_10',
        );

        $referencia = array( 'asignatura' );

        $referenciaMultiple = array(
            'profesores',
            'datosEspecificos_4_1',
            'datosEspecificos_4_2',
            'datosEspecificos_9_2',
        );

        if(in_array($nombre, $campos)) return 1;
        if(in_array($nombre, $referencia)) return 2;
        if(in_array($nombre, $referenciaMultiple)) return 3;
        return 0;
    }

    public function updateAction($id, Request $request)
    {
        $response = new Response();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);

        if($entity) {
            $fields = array('nombre','descripcion');

            $data = json_decode($request->getContent());

            foreach($data as $name => $value) {
                switch($this->tipoDeCampo($name)) {
                    case 1:
                        $method = 'set'.ucfirst($name);
                        call_user_func(array($entity, $method), $value);
                        break;

                    case 2:
                        switch($name) {
                            case 'asignatura':
                                $entidad = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($value);
                                break;
                        }
                        $method = 'set'.ucfirst($name);
                        call_user_func(array($entity, $method), $entidad);
                        break;
                        
                    case 3:
                        $method = 'clear'.ucfirst($name);
                        call_user_func(array($entity, $method));

                        switch($name) {
                            case 'profesores': $cadena = 'EtsiAppGuiasBundle:Profesor'; break;
                            case 'datosEspecificos_4_1': 
                            case 'datosEspecificos_4_2': $cadena = 'EtsiAppGuiasBundle:Competencia'; break;
                            case 'datosEspecificos_9_2': $cadena = 'EtsiAppGuiasBundle:Semana'; break;
                        }

                        $method = 'add'.ucfirst($name);
                        foreach($value as $id) {
                            $entidad = $em->getRepository($cadena)->find($id);
                            call_user_func(array($entity, $method), $entidad);
                        }
                        break;
                }
            }

            $em->flush();

            $response->setStatusCode('200');
            $response->headers->set('Content-Type', 'application/json');
        } else
            $response->setStatusCode('400');

        return $response;
    }

    public function getAction($id, Request $request)
    {
        $response = new Response();
        $datosDeRespuesta = array();

        $datosRequeridos = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);

        if ($entity && $datosRequeridos) {
            foreach($datosRequeridos->peticion as $dato) {
                $method = 'get'.ucfirst($dato);
                $resultado = call_user_func(array($entity, $method));
                switch($this->tipoDeCampo($dato)) {
                    case 1:
                        $datosDeRespuesta[$dato] = $resultado;
                        break;

                    case 2:
                        $datosDeRespuesta[$dato] = $resultado->getId();
                        break;
                        
                    case 3:
                        foreach($resultado as $entidad)
                            $datosDeRespuesta[$dato][] = $entidad->getId();
                        break;
                }
            }

            $response->setStatusCode('200');
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($datosDeRespuesta));
        } else {
            $response->setStatusCode('400');
        }

        return $response;
    }

    public function pasosAction($id)
    {
        return $this->render(
            'EtsiAppGuiasBundle::guiaLayout.html.twig',
            array(
                'id' => $id,
            )
        );
    }
}
