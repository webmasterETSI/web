<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Ps\PdfBundle\Annotation\Pdf;
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
            'nombreI',
            'coordinador',
            'semanas'
        );

        $referenciaMultiple = array(
            'profesores',
            'datosEspecificos_4_1',
            'datosEspecificos_4_2',
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
        $estado = $entity->getEstado();

        if( $entity ) {
            $data = json_decode($request->getContent());

            if($estado==0 || $estado==3) {
                $fields = array('nombre','descripcion');
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

                                case 'coordinador':
                                    $entidad = $em->getRepository('EtsiAppGuiasBundle:Profesor')->find($value);
                                    $entity->getAsignatura()
                                        ->setCoordinador($entidad);
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

                $response->setStatusCode('200');
                $entity->setFechaDeModificacion(new DateTime());
                $em->flush();
            } else if(isset($data->estado)) {
                $entity->setEstado($data->estado);

                $response->setStatusCode('200');
                $entity->setFechaDeModificacion(new DateTime());
                $em->flush();
            } else {
                $response->setStatusCode('400');
                $response->setContent('Cambios no guardados: la guía no puede modificarse pues su estado actual es '.($estado==1?'pendiente de aprobación':'publicada'));
            }

            if(isset($data->estado)) {
                $tmpResponse = new Response();
                $this->render(
                    'EtsiAppGuiasBundle:Mail:cambioEstado.html.twig',
                    array('guia' => $entity),
                    $tmpResponse
                );
                $mensaje = $tmpResponse->getContent();

                $to = '';
                $profesor = $entity->getCreador();
                if($profesor) {
                    $email = $profesor->getEmail();
                    if(!empty($email)) $to .= $email;
                }
                foreach($entity->getProfesores() as $profesor) {
                    $email = $profesor->getEmail();
                    if(!empty($email)) {
                        if($to!='') $to .= ',';
                        $to .= $email;
                    }
                }

                $subject = 'App GuíaMe: estado de guía modificado';
                $head  = 'Content-type: text/html; charset=iso-8859-1';

                mail($to, $subject, $mensaje, $head);
            }
        } else {
            $response->setStatusCode('400');
            $response->setContent('Cambios no guardados: guía no encontrada');
        }

        return $response;
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $profesor = $this->get('security.context')->getToken()->getUser();
        $guia = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);

        if($guia) {
            $creador = $guia->getCreador();
            if($creador && $profesor->getId() == $creador->getId()) {
                $guia->clearProfesores();
                $guia->clearDatosEspecificos_4_1();
                $guia->clearDatosEspecificos_4_2();

                foreach($guia->getDatosEspecificos_10() as $semana) {
                    $guia->removeDatosEspecificos_10($semana);
                    $em->remove($semana);
                }

                $em->remove($guia);
                $em->flush();
                return $this->indexAction( array('success' => array('Guía eliminada correctamente')) );
            }
            else {
                return $this->indexAction( array('error' => array('No se ha podido eliminar la guía: no eres el creador de la guía.')) );
            }
        }
        return $this->indexAction( array('error' => array('No se ha podido eliminar la guía: la guía no existe.')) );
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idAsignatura = $request->request->get('asignatura');
        $curso = date('Y');

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
                $profesor = $this->get('security.context')->getToken()->getUser();

                $guia = new Guia();

                $guia->setCurso($curso);
                $guia->setAsignatura($asignatura);
                $guia->setFechaDeModificacion(new DateTime());
                $guia->setCreador($profesor);
                if($asignatura->getCoordinador())
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

            $enGrados = $guia->getAsignatura()->getEnGrados();

            $competencias = new \Doctrine\Common\Collections\ArrayCollection();
            foreach($enGrados as $asignaturaGrado) {
                $grado = $asignaturaGrado->getGrado();
                $competenciasDeGrado = $grado->getCompetenciasDeGrado();
                foreach($competenciasDeGrado as $competencia)
                    $competencias[$competencia->getId()] = $competencia;
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

    public function getPdfAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $guia = $em->getRepository('EtsiAppGuiasBundle:Guia')->find($id);
        if($guia) {
            $facade = $this->get('ps_pdf.facade');
            $response = new Response();
            $this->render('EtsiAppGuiasBundle:PDF:guia.pdf.twig', array('guia' => $guia), $response);
            $documentXml = $response->getContent();
            $this->render('EtsiAppGuiasBundle:PDF:guia.style.twig', array(), $response);
            $stylesheetXml = $response->getContent();

            $content = $facade->render($documentXml, $stylesheetXml);

            $asignatura = $guia->getAsignatura();
            $curso = $asignatura->getCurso();
            $nombre = Herramientas::slugify($asignatura->getNombre());

            $header = array(
                'content-type' => 'application/pdf',
                //'Content-Disposition' => 'attachment; filename="'.$curso.'.'.$nombre.'.pdf"',
                'Content-Disposition' => 'attachment; filename="'.$asignatura->getId().'.pdf"',
            );

            return new Response($content, 200, $header);
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
        $profesores = $em->getRepository('EtsiAppGuiasBundle:Profesor')->findAll();

        $entity = $this->get('security.context')->getToken()->getUser();
        $guias = $em->getRepository('EtsiAppGuiasBundle:Guia')->findAll();
        $areas = $em->getRepository('EtsiAppGuiasBundle:Area')->findAll();
        $grados = $em->getRepository('EtsiAppGuiasBundle:Grado')->findAll();


        $qbGuias  = $em->createQueryBuilder();
        $qbAsignaturas  = $em->createQueryBuilder();

        $query = $qbAsignaturas
            ->select('a')
            ->from('EtsiAppGuiasBundle:Asignatura', 'a')
            ->where(
                $qbAsignaturas->expr()->notIn(
                    'a.id',
                    $qbGuias->select('asig.id')
                        ->from('EtsiAppGuiasBundle:Guia', 'g')
                        ->leftJoin('g.asignatura', 'asig')
                        ->where('g.curso='.date('Y'))
                        ->getDQL()
                )
            )
            ->orderBy('a.nombre', 'ASC')
            ->getQuery();

        $asignaturas = $query->getResult();

        return $this->render(
            'EtsiAppGuiasBundle::dashboard.html.twig',
            array(
                'guias' => $guias,
                'areas' => $areas,
                'entity' => $entity,
                'grados' => $grados,
                'profesores' => $profesores,
                'asignaturas' => $asignaturas,
                'messages' => $mensajes
            )
        );
    }

    public function feedbackAction(Request $request)
    {
        $response = new Response();
        $to = 'webmaster.etsi@gmail.com';
        $subject = 'Feedback APP guías';
        $head  = 'Content-type: text/html; charset=iso-8859-1';

        $data = json_decode($request->getContent());

        $response->headers->set('Content-Type', 'application/json');

        if(isset($data->tipo) && !empty($data->tipo) &&
           isset($data->contenido) && !empty($data->contenido)) {
            $securityContext = $this->get('security.context');
            if($securityContext->isGranted('ROLE_PROFESOR') ){
                $entity = $this->get('security.context')->getToken()->getUser();
                if(mail($to, $subject , $data->contenido.'<br /><br /><b>'.$data->tipo.'</b>', $head)) {
                    $response->setStatusCode('200');
                    $response->setContent('{ "error": "Mensaje enviado correctamente" }');
                    return $response;
                } else $response->setContent('{ "error": "No se ha podido enviar el correo" }');
            } else $response->setContent('{ "error": "El usuario no se encuentra identificado" }');
        } else $response->setContent('{ "error": "Faltan datos" }');

        $response->setStatusCode('400');
        return $response;
    }

    public function personalDataAction(Request $request)
    {
        $profesor = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $profesor->setDespacho($request->request->get('despacho'));
        $profesor->setNombre($request->request->get('nombre'));
        $profesor->setTlf($request->request->get('telefono'));
        $profesor->setEmail($request->request->get('email'));
        $em->flush();

        return $this->indexAction( array('success' => array('Datos modificados')) );
    }
}
