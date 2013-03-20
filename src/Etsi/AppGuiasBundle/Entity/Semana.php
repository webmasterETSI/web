<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="semana")
 * @ORM\Entity
 */
class Semana
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Guia", inversedBy="datosEspecificos_9_2")
     */
    protected $guia;


    /**
     * @ORM\Column(type="integer")
     */
    protected $numeroSemana;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $horasGruposGrandes;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $horasGruposReducidosAula;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $horasGruposReducidosInformatica;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $horasGruposReducidosLaboratorio;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $horasGruposReducidosCampo;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $examen;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $observaciones;
}