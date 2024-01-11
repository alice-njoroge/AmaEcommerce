<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register_user', methods: ['POST'])]
    public function registerUser(Request $request, LoggerInterface $logger): JsonResponse
    {
        $data = $request->toArray();
        $logger->info(json_encode($data));

        return $this->json($data);
    }
}
