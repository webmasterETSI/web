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
            '&auml;',
            '&euml;',
            '&iuml;',
            '&ouml;',
            '&uuml;',
            '&acirc;',
            '&ecirc;',
            '&icirc;',
            '&ocirc;',
            '&ucirc;',
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
            '&Auml;',
            '&Euml;',
            '&Iuml;',
            '&Ouml;',
            '&Uuml;',
            '&Acirc;',
            '&Ecirc;',
            '&Icirc;',
            '&Ocirc;',
            '&Ucirc;',
            '&ntilde;',
            '&Ntilde;',
            '&ordf;',
            '&acute;',
            '&ordm;',
            '&bull;',
            '&oslash;',
            '&Oslash;',
            '&iquest;',
            '&middot;',
            '&laquo;',
            '&raquo;',
            '&ccedil;',
            '&Ccedil;',
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
            'ä',
            'ë',
            'ï',
            'ö',
            'ü',
            'â',
            'ê',
            'î',
            'ô',
            'û',
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
            'Ä',
            'Ë',
            'Ï',
            'Ö',
            'Ü',
            'Â',
            'Ê',
            'Î',
            'Ô',
            'Û',
            'ñ',
            'Ñ',
            'ª',
            '´',
            'º',
            '•',
            'ø',
            'Ø',
            '¿',
            '·',
            '«',
            '»',
            'ç',
            'Ç',
        );

        $regex_search = array(
            '/ start="(\d+)"/',
            '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
        );

        $regex_replace = array(
            '',
            ' ',
        );

        return preg_replace($regex_search, $regex_replace, str_replace($simple_search, $simple_replace, $texto));
    }

    public function getName()
    {
        return 'pdf_extension';
    }
}
