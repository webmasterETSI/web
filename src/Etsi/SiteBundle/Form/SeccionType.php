<?php
namespace Etsi\SiteBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Etsi\SiteBundle\Entity\Usuario,
    Etsi\SiteBundle\Entity\Seccion;


class SeccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('titulo', 'text');
        $builder->add('imagen', 'text', array('required' => false));
        $builder->add('descripcion', 'text', array('required' => false));

        $builder->add('editores', 'entity', array(
            'class'    => 'EtsiSiteBundle:Usuario',
            'property' => 'nick',
            'required' => false,
            'multiple' => true,
        ));
    }

    public function getName()
    {
        return 'seccion';
    }
}