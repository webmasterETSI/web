<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminSemanaController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Semana: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Semana: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Semana: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Semana: Mostrar");
    }
}
