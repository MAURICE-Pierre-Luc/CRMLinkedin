<?php

namespace App\Controller;

use App\Entity\Recruiter;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


class RecruiterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Liste tous les recruteurs
    #[Route('/api/recruiters', name: 'app_recruiter_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            if (!$this->checkKey($request)) {
                throw new BadRequestHttpException("Bad Request");
            }
            $recruiters = $this->entityManager->getRepository(Recruiter::class)->findAll();

            $data = [];
            foreach ($recruiters as $recruiter) {
                $data[] = [
                    'id' => $recruiter->getId(),
                    'firstName' => $recruiter->getFirstName(),
                    'lastName' => $recruiter->getLastName(),
                    'company' => $recruiter->getCompany(),
                    'email' => $recruiter->getEmail(),
                    'linkedinProfile' => $recruiter->getLinkedinProfile(),
                    'phone' => $recruiter->getPhone(),
                    'status' => $recruiter->getStatus(),
                    'notes' => $recruiter->getNotes(),
                    'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
                ];
            }

            return new JsonResponse($data);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['error' => 'Bad Request: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Récupère un recruteur par son ID
    #[Route('/api/recruiters/{id}', name: 'app_recruiter_show', methods: ['GET'])]
    public function show(Recruiter $recruiter, Request $request): JsonResponse
    {
        try {
            if (!$this->checkKey($request)) {
                throw new BadRequestHttpException("Bad Request");
            }
            $data = [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName(),
                'company' => $recruiter->getCompany(),
                'email' => $recruiter->getEmail(),
                'linkedinProfile' => $recruiter->getLinkedinProfile(),
                'phone' => $recruiter->getPhone(),
                'status' => $recruiter->getStatus(),
                'notes' => $recruiter->getNotes(),
                'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            return new JsonResponse($data);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['error' => 'Bad Request: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Crée un nouveau recruteur
    #[Route('/api/recruiters', name: 'app_recruiter_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            if (!empty($data['firstName']) || !empty($data['lastName']) || !empty($data['email']) || !$this->checkKey($request)) {
                throw new BadRequestHttpException("Bad Request");
            }

            $data = json_decode($request->getContent(), true);

            $recruiter = new Recruiter();
            $recruiter->setFirstName($data['firstName']);
            $recruiter->setLastName($data['lastName']);
            $recruiter->setCompany($data['company']);
            $recruiter->setLinkedinProfile($data['linkedinProfile']);
            $recruiter->setEmail($data['email']);
            $recruiter->setPhone($data['phone'] ?? null);
            $recruiter->setStatus($data['status']);
            $recruiter->setNotes($data['notes'] ?? null);
            $recruiter->setCreatedAt(new \DateTime());
            $recruiter->setUpdatedAt(new \DateTime());

            $this->entityManager->persist($recruiter);
            $this->entityManager->flush();

            $responseData = [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName(),
                'company' => $recruiter->getCompany(),
                'email' => $recruiter->getEmail(),
                'linkedinProfile' => $recruiter->getLinkedinProfile(),
                'phone' => $recruiter->getPhone(),
                'status' => $recruiter->getStatus(),
                'notes' => $recruiter->getNotes(),
                'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            return new JsonResponse($responseData, Response::HTTP_CREATED);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['error' => 'Bad Request: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Met à jour un recruteur existant
    #[Route('/api/recruiters/{id}', name: 'app_recruiter_update', methods: ['PUT'])]
    public function update(Request $request, Recruiter $recruiter): JsonResponse
    {
        try {
            if (!$this->checkKey($request)) {
                return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }
            $data = json_decode($request->getContent(), true);

            if (isset($data['firstName'])) {
                $recruiter->setFirstName($data['firstName']);
            }
            if (isset($data['lastName'])) {
                $recruiter->setLastName($data['lastName']);
            }
            if (isset($data['company'])) {
                $recruiter->setCompany($data['company']);
            }
            if (isset($data['linkedinProfile'])) {
                $recruiter->setLinkedinProfile($data['linkedinProfile']);
            }
            if (isset($data['email'])) {
                $recruiter->setEmail($data['email']);
            }
            if (isset($data['phone'])) {
                $recruiter->setPhone($data['phone']);
            }
            if (isset($data['status'])) {
                $recruiter->setStatus($data['status']);
            }
            if (isset($data['notes'])) {
                $recruiter->setNotes($data['notes']);
            }

            $recruiter->setUpdatedAt(new \DateTime());

            $this->entityManager->flush();

            $responseData = [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName(),
                'company' => $recruiter->getCompany(),
                'email' => $recruiter->getEmail(),
                'linkedinProfile' => $recruiter->getLinkedinProfile(),
                'phone' => $recruiter->getPhone(),
                'status' => $recruiter->getStatus(),
                'notes' => $recruiter->getNotes(),
                'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            return new JsonResponse($responseData);
        } catch (BadRequestHttpException $e) {
            return new JsonResponse(['error' => 'Bad Request: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Supprime un recruteur
    #[Route('/api/recruiters/{id}', name: 'app_recruiter_delete', methods: ['DELETE'])]
    public function delete(Recruiter $recruiter, Request $request): JsonResponse
    {   try{
        if (!$this->checkKey($request)) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $this->entityManager->remove($recruiter);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    } catch (BadRequestHttpException $e) {
        return new JsonResponse(['error' => 'Bad Request: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
    } catch (\Exception $e) {
        return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    private function checkKey(Request $request): bool
    {
        $providedKey = $request->query->get('key');
        $expectedKey = $_ENV['API_ACCESS_KEY'] ?? 'default_key';

        return $providedKey === $expectedKey;
    }
}