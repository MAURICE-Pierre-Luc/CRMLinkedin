<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/api/hello/{name}', name: 'app_hello_world', methods: ['GET'])]
    public function index(string $name): JsonResponse
    {
        return $this->json([
            'message' => "Hello " . $name . " !",
            'timestamp' => new \DateTime()
        ]);
    }
}