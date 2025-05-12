<?php

namespace App\Controller;

use App\Entity\Opportunity;
use App\Entity\Recruiter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/opportunities')]
class OpportunityController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Liste toutes les opportunités
    #[Route('', name: 'app_opportunity_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $opportunities = $this->entityManager->getRepository(Opportunity::class)->findAll();
        
        $data = [];
        foreach ($opportunities as $opportunity) {
            $data[] = [
                'id' => $opportunity->getId(),
                'jobTitle' => $opportunity->getJobTitle(),
                'company' => $opportunity->getCompany(),
                'contractType' => $opportunity->getContractType(),
                'location' => $opportunity->getLocation(),
                'salaryMin' => $opportunity->getSalaryMin(),
                'salaryMax' => $opportunity->getSalaryMax(),
                'salaryCurrency' => $opportunity->getSalaryCurrency(),
                'status' => $opportunity->getStatus(),
                'recruiter' => [
                    'id' => $opportunity->getRecruiter()->getId(),
                    'firstName' => $opportunity->getRecruiter()->getFirstName(),
                    'lastName' => $opportunity->getRecruiter()->getLastName()
                ],
                'createdAt' => $opportunity->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $opportunity->getUpdatedAt()->format('Y-m-d H:i:s')
            ];
        }
        
        return new JsonResponse($data);
    }

    // Crée une nouvelle opportunité
    #[Route('', name: 'app_opportunity_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $recruiter = $this->entityManager->getRepository(Recruiter::class)->find($data['recruiterId']);
        
        if (!$recruiter) {
            return new JsonResponse(['error' => 'Recruiter not found'], Response::HTTP_NOT_FOUND);
        }
        
        $opportunity = new Opportunity();
        $opportunity->setJobTitle($data['jobTitle']);
        $opportunity->setCompany($data['company']);
        $opportunity->setContractType($data['contractType']);
        $opportunity->setLocation($data['location']);
        $opportunity->setSalaryMin($data['salaryMin'] ?? null);
        $opportunity->setSalaryMax($data['salaryMax'] ?? null);
        $opportunity->setSalaryCurrency($data['salaryCurrency'] ?? null);
        $opportunity->setStatus($data['status']);
        $opportunity->setRecruiter($recruiter);
        $opportunity->setCreatedAt(new \DateTime());
        $opportunity->setUpdatedAt(new \DateTime());
        
        $this->entityManager->persist($opportunity);
        $this->entityManager->flush();
        
        $responseData = [
            'id' => $opportunity->getId(),
            'jobTitle' => $opportunity->getJobTitle(),
            'company' => $opportunity->getCompany(),
            'contractType' => $opportunity->getContractType(),
            'location' => $opportunity->getLocation(),
            'salaryMin' => $opportunity->getSalaryMin(),
            'salaryMax' => $opportunity->getSalaryMax(),
            'salaryCurrency' => $opportunity->getSalaryCurrency(),
            'status' => $opportunity->getStatus(),
            'recruiter' => [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName()
            ],
            'createdAt' => $opportunity->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $opportunity->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
        
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    // Autres méthodes (show, update, delete) à implémenter de façon similaire
}