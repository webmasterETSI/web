<?php
namespace Etsi\SiteBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Etsi\SiteBundle\Entity\Contenido,
    Etsi\SiteBundle\Entity\Seccion;


class ContenidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('titulo', 'text');
        $builder->add('imagen', 'text', array('required' => false));
        $builder->add('resumen', 'text', array('required' => false));
        $builder->add('descripcion', 'text');
        $builder->add('fecha', 'date');
/*
        //El autor se gestionara automaticamente
        $builder->add('autor', 'entity', array(
            'class'    => 'EtsiSiteBundle:Usuario',
            'property' => 'nick',
            'required' => false
        ));
*/
        $builder->add('secciones', 'entity', array(
            'class'    => 'EtsiSiteBundle:Seccion',
            'property' => 'titulo',
            'required' => false,
            'multiple' => true,
        ));
    }

    public function getName()
    {
        return 'contenido';
    }
}