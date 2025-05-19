<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class swagger extends AbstractController
{
    /**
     * @Route("/api/hello", methods={"GET"})
     *
     * @OA\Get(
     *     path="/api/hello",
     *     summary="Dire bonjour",
     *     description="Retourne un message de bienvenue.",
     *     @OA\Response(
     *         response=200,
     *         description="Succès"
     *     )
     * )
     */
    public function hello(): JsonResponse
    {
        return new JsonResponse(['message' => 'Bonjour !']);
    }
}
