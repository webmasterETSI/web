<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminAsignaturaController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Asignatura: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Asignatura: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Asignatura: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Asignatura: Mostrar");
    }
}
