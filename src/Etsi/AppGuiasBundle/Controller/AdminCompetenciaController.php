<?php

namespace Etsi\AppGuiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Response;

class AdminCompetenciaController extends Controller
{
    public function listAction()
    {
        return new Response("Admin Competencia: Listar");
    }

    public function newAction()
    {
        return new Response("Admin Competencia: Nuevo");
    }

    public function editAction($id)
    {
        return new Response("Admin Competencia: Editar");
    }

    public function showAction($id)
    {
        return new Response("Admin Competencia: Mostrar");
    }
}
