<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;
    
use Ps\PdfBundle\Annotation\Pdf;

/**
 * @Pdf()
 */
class PdfController extends Controller
{
    public function testAction()
    {
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('EtsiAppGuiasBundle:PDF:factura.pdf.twig', array(), $response);

        $xml = $response->getContent();

        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
}