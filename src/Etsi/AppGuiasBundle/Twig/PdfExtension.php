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
        $simple_search  = array(
            '&nbsp;',
            '&ensp;',
            '&ldquo;',
            '&rdquo;',
            '&quot;',
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
            '&ordf;',
            '&acute;',
        );

        $simple_replace = array(
            ' ',
            ' ',
            '"',
            '"',
            '"',
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
            'ª',
            '´',
        );

        $regex_search = array(
            '/<ol start="(\d+)">/',
        );

        $regex_replace = array(
            '<ol>',
        );

        return preg_replace($regex_search, $regex_replace, str_replace($simple_search, $simple_replace, $texto));
    }

    public function getName()
    {
        return 'pdf_extension';
    }
}
