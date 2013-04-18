<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Common\Herramientas;
use DateTime;

use Etsi\AppGuiasBundle\Entity\Asignatura,
    Etsi\AppGuiasBundle\Entity\Competencia,
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
            'datosEspecificos_9_2',
        );

        $especial = array(
            //'asignatura',
            'nombreI',
            'semanas'
        );

        $referenciaMultiple = array(
            'profesores',
            'datosEspecificos_4_1',
            'datosEspecificos_4_2',
            //'datosEspecificos_10',
        );

        if(in_array($nombre, $campos)) return 1;
        if(in_array($nombre, $especial)) return 2;
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
                                $entity->setAsignatura($entidad);
                                break;

                            case 'nombreI':
                                $entity->getAsignatura()
                                    ->setNombreI($value);
                                break;

                            case 'semanas':
                                $semanas = $entity->getDatosEspecificos_10();
                                foreach($value as $semana) {
                                    $num = $semana->numeroSemana-1;
                                    if(isset($semanas[$num]) && !empty($semanas[$num])) {
                                        $semanas[$num]->setHorasGruposGrandes($semana->horasGruposGrandes);
                                        $semanas[$num]->setHorasGruposReducidosAula($semana->horasGruposReducidosAula);
                                        $semanas[$num]->setHorasGruposReducidosInformatica($semana->horasGruposReducidosInformatica);
                                        $semanas[$num]->setHorasGruposReducidosLaboratorio($semana->horasGruposReducidosLaboratorio);
                                        $semanas[$num]->setHorasGruposReducidosCampo($semana->horasGruposReducidosCampo);
                                        $semanas[$num]->setExamen($semana->examen);
                                        $semanas[$num]->setObservaciones($semana->observaciones);
                                    }
                                }
                                break;
                        }
                        break;
                        
                    case 3:
                        $method = 'clear'.ucfirst($name);
                        call_user_func(array($entity, $method));

                        switch($name) {
                            case 'profesores': $cadena = 'EtsiAppGuiasBundle:Profesor'; break;
                            case 'datosEspecificos_4_1': 
                            case 'datosEspecificos_4_2': $cadena = 'EtsiAppGuiasBundle:Competencia'; break;
                            case 'datosEspecificos_10': $cadena = 'EtsiAppGuiasBundle:Semana'; break;
                        }

                        $method = 'add'.ucfirst($name);
                        foreach($value as $id) {
                            $entidad = $em->getRepository($cadena)->find($id);
                            call_user_func(array($entity, $method), $entidad);
                        }
                        break;
                }
            }
            $entity->setFechaDeModificacion(new DateTime());

            $em->flush();

            $response->setStatusCode('200');
            $response->headers->set('Content-Type', 'application/json');
        } else
            $response->setStatusCode('400');

        return $response;
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idAsignatura = $request->request->get('asignatura');
        $curso = $request->request->get('curso');

        $asignatura = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($idAsignatura);
        if($asignatura) {
            $mensajes = array('info' => array('La guía ya existía, guía cargada'));

            $query = $em->getRepository('EtsiAppGuiasBundle:Guia')
                ->createQueryBuilder('g')
                ->where('g.asignatura = :asignatura AND g.curso = :curso')
                ->setParameter('asignatura', $idAsignatura)
                ->setParameter('curso', $curso)
                ->getQuery();

            $guia = $query->getOneOrNullResult();

            if(!$guia) {
                $guia = new Guia();

                $guia->setCurso($curso);
                $guia->setAsignatura($asignatura);
                $guia->setFechaDeModificacion(new DateTime());
                $guia->addProfesores($asignatura->getCoordinador());

                $em->persist($guia);
                $em->flush();

                $semanas = $asignatura->getCuatrimestre()==3?30:15;

                for($i=1; $i<=$semanas; $i++) {
                    $semana = new Semana();

                    $semana->setNumeroSemana($i);
                    $semana->setGuia($guia);

                    $em->persist($semana);
                }
                $em->flush();
                $em->clear();
                $mensajes = array('success' => array('Guía creada correctamente'));
            }
            return $this->pasosAction($guia->getId(), $mensajes);
        }


        return $this->indexAction( array('error' => array('No se ha podido crear la guía')) );
    }

    public function pasosAction($id, $mensajes = array())
    {
        $em = $this->getDoctrine()->getManager();
        
        $guia = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);
        if($guia) {
            $grados = $em->getRepository('EtsiAppGuiasBundle:Grado')->findAll();
            $semanas = $guia->getDatosEspecificos_10();
            $profesores = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findAll();

            $gradosAsignatura = $guia->getAsignatura()->getGrados();
            $competencias = new \Doctrine\Common\Collections\ArrayCollection();

            foreach($gradosAsignatura as $grado) {
                $competenciasDeGrado = $grado->getCompetenciasDeGrado();
                foreach($competenciasDeGrado as $competencia)
                    $competencias[] = $competencia;
            }

            return $this->render(
                'EtsiAppGuiasBundle::guia.html.twig',
                array(
                    'guia' => $guia,
                    'grados' => $grados,
                    'semanas' => $semanas,
                    'profesores' => $profesores,
                    'competencias' => $competencias,
                    'messages' => $mensajes
                )
            );
        }

        return $this->indexAction( array('error' => array('No se ha podido cargar la guía')) );
    }


    public function coordinadorAction(Request $request)
    {
        $idAsignatura = $request->request->get('asignatura');
        $idProfesor = $request->request->get('profesor');

        if(!empty($idAsignatura) && !empty($idProfesor)) {
            $em = $this->getDoctrine()->getManager();
            $asignatura = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->find($idAsignatura);
            $profesor = $em->getRepository('EtsiAppGuiasBundle:Profesor')->find($idProfesor);

            if($asignatura && $profesor) {
                $asignatura->setCoordinador($profesor);
                $em->flush();
                return $this->indexAction( array('success' => array('Asignado '.$profesor->getNombre().' como coordinador de '.$asignatura->getNombre())) );
            }
            return $this->indexAction( array('error' => array('El profesor o la asignatura seleccionado no existe')) );
        }

        return $this->indexAction( array('error' => array('IDs incorrectos')) );
    }

    public function indexAction($mensajes = array())
    {
        $em = $this->getDoctrine()->getManager();
        $guias = $em->getRepository('EtsiAppGuiasBundle:Guia')->findAll();
        $profesores = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findAll();
        $asignaturas = $em->getRepository('EtsiAppGuiasBundle:Asignatura')->findAll();

        $entity = $this->get('security.context')->getToken()->getUser();

        return $this->render(
            'EtsiAppGuiasBundle::dashboard.html.twig',
            array(
                'entity' => $entity,
                'guias' => $guias,
                'profesores' => $profesores,
                'asignaturas' => $asignaturas,
                'messages' => $mensajes
            )
        );
    }
}
