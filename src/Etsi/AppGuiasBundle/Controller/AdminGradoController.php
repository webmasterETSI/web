<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminGradoController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Grado: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Grado: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Grado: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Grado: Mostrar");
    }
}
