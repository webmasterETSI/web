<?php

namespace Etsi\AppGuiasBundle\Twig;

class PdfExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('pdf', array($this, 'pdfFilter')),
        );
    }

    public function pdfFilter($texto)
    {
        $search  = array(
            '&nbsp;',
            '<tbody>',
            '</tbody>',
            '&aacute;',
            '&eacute;',
            '&iacute;',
            '&oacute;',
            '&uacute;',
            '&Aacute;',
            '&Eacute;',
            '&Iacute;',
            '&Oacute;',
            '&Uacute;',
            '&ntilde;',
            '&Ntilde;',
        );

        $replace = array(
            '',
            '',
            '',
            'á',
            'é',
            'í',
            'ó',
            'ú',
            'Á',
            'É',
            'Í',
            'Ó',
            'Ú',
            'ñ',
            'Ñ',
        );

        return str_replace($search, $replace, $texto);
    }

    public function getName()
    {
        return 'pdf_extension';
    }
}