<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * @Pdf()
 */


class PdfController extends Controller
{
    public function testAction()
    {
        $formato = $this->get('request')->get('_format');

        return $this->render(sprintf('EtsiAppGuiasBundle:PDF:factura.%s.twig', $formato));
    }

}