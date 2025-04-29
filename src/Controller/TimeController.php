<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TimeController extends AbstractController
{
    #[Route('api/time', name: 'app_time')]
    public function index(): JsonResponse
    {
        date_default_timezone_set('Europe/Paris');
        
        return $this->json([
            'message' => new \DateTime(),
        ]);
    }
}
