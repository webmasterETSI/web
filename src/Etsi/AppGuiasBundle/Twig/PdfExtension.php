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
            '&lsquo;',
            '&rsquo;',
            '&quot;',
            '<tbody>',
            '</tbody>',
            '&aacute;',
            '&eacute;',
            '&iacute;',
            '&oacute;',
            '&uacute;',
            '&agrave;',
            '&egrave;',
            '&igrave;',
            '&ograve;',
            '&ugrave;',
            '&uuml;',
            '&Aacute;',
            '&Eacute;',
            '&Iacute;',
            '&Oacute;',
            '&Uacute;',
            '&Agrave;',
            '&Egrave;',
            '&Igrave;',
            '&Ograve;',
            '&Ugrave;',
            '&Uuml;',
            '&ntilde;',
            '&Ntilde;',
            '&ordf;',
            '&acute;',
            '&ordm;',
            '&bull;',
            '&Oslash;',
            '&iquest;',
            '&middot;',
        );

        $simple_replace = array(
            ' ',
            ' ',
            '"',
            '"',
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
            'à',
            'è',
            'ì',
            'ò',
            'ù',
            'ü',
            'Á',
            'É',
            'Í',
            'Ó',
            'Ú',
            'À',
            'È',
            'Ì',
            'Ò',
            'Ù',
            'Ü',
            'ñ',
            'Ñ',
            'ª',
            '´',
            'º',
            '•',
            'Ø',
            '¿',
            '·',
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
