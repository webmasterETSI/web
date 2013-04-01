<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminProfesorController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Profesor: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Profesor: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Profesor: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Profesor: Mostrar");
    }
}
