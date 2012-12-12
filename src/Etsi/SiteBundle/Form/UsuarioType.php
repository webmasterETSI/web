<?php
namespace Etsi\SiteBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Etsi\SiteBundle\Entity\Usuario,
    Etsi\SiteBundle\Entity\Seccion;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nick', 'text');
        $builder->add('pass', 'password');
        $builder->add('imagen', 'text');

        $builder->add('seccion', 'entity', array(
            'class'    => 'EtsiSiteBundle:Seccion',
            'property' => 'titulo',
            'required' => false
        ));
    }

    public function getName()
    {
        return 'usuario';
    }
}