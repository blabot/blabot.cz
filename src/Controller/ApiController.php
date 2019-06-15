<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        $json = "{'Hello': 'World!'}";
        $response = new Response($json, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
