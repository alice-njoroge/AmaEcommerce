<?php

namespace App\Controller;

use App\Entity\User;
use App\useCases\SaveUserUseCase;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    private SaveUserUseCase $saveUserUseCase;

    public function __construct(SaveUserUseCase $saveUserUseCase)
    {
        $this->saveUserUseCase = $saveUserUseCase;

    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/register', name: 'app_register_user', methods: ['POST'])]
    public function registerUser(Request $request, LoggerInterface $logger): JsonResponse
    {
        $data = $request->toArray();
        $logger->debug(json_encode($data));

        $this->saveUserUseCase->execute($data);

        return $this->json($data['email']);
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function loginUser(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user){
            return $this->json(['message' => 'invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $roles = $user->getRoles();
        dd($roles);

        return $this->json([ 'user'  => $user->getUserIdentifier()]);

    }
    #[Route('/logout', name: 'user_logout', methods: ['GET'])]
    public function logout(): Response
    {
        throw new LogicException('This method has no logic - it will be intercepted by the logout key in the firewall.');
    }
}
