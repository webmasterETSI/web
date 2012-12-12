<?php
namespace Etsi\SiteBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Etsi\SiteBundle\Entity\Usuario,
    Etsi\SiteBundle\Entity\Contenido,
    Etsi\SiteBundle\Entity\Seccion;


class SeccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', 'text');
        $builder->add('imagen', 'text');
        $builder->add('descripcion', 'text');

        $builder->add('editores', 'entity', array(
            'class'    => 'EtsiSiteBundle:Usuario',
            'property' => 'nick',
            'required' => false
        ));

        $builder->add('contenidos', 'entity', array(
            'class'    => 'EtsiSiteBundle:Contenido',
            'property' => 'titulo',
            'required' => false
        ));
    }

    public function getName()
    {
        return 'seccion';
    }
}