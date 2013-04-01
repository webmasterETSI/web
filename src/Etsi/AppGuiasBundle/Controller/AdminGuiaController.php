<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminGuiaController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Guia: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Guia: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Guia: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Guia: Mostrar");
    }
}
