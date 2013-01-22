<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="guia")
 * @ORM\Entity
 */
class Guia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    protected $grado;

    protected $aprobada;


    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombreI;

    /**
     * @ORM\Column(type="integer")
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string")
     */
    protected $caracter;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosTeoricos;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPAula;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPInformatica;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPLaboratorio;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPCampo;

    /**
     * @ORM\Column(type="string")
     */
    protected $departamento;

    /**
     * @ORM\Column(type="string")
     */
    protected $area;

    /**
     * @ORM\Column(type="integer")
     */
    protected $curso;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cuatrimestre;

    /**
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="asignaturas")
     * @ORM\JoinColumn(name="Profesor_id", referencedColumnName="id")
     */
    protected $profesor;


    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_3;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_4_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_4_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_5;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_1;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_2;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_3;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_4;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_5;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_6;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_6_1_7;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_6_1_8;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_6_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_7;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_8_1;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_8_2;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_1;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_2;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_3;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_4;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_5;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $datosEspecificos_9_1_6;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_9_1_7;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_9_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_10_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_10_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $extra;
}