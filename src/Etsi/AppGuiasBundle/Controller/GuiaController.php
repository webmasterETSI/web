<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;

use Etsi\AppGuiasBundle\Entity\Competencia,
    Etsi\AppGuiasBundle\Entity\Grado,
    Etsi\AppGuiasBundle\Entity\Guia,
    Etsi\AppGuiasBundle\Entity\Profesor,
    Etsi\AppGuiasBundle\Entity\Semana;

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

    public function pasosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $guia = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);
        $grados = $em->getRepository('EtsiAppGuiasBundle:Grado')->findAll();
        $semanas = $em->getRepository('EtsiAppGuiasBundle:Semana')->findByGuia($id);
        $profesores = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findAll();
        //pendiente competencias

        return $this->render(
            'EtsiAppGuiasBundle::guiaLayout.html.twig',
            array(
                'guia' => $guia,
                'grados' => $grados,
                'semanas' => $semanas,
                'profesores' => $profesores,
            )
        );
    }
}
