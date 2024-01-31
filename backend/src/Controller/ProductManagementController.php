<?php

namespace App\Controller;

use App\useCases\SaveProductUseCase;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class ProductManagementController extends AbstractController
{
    public function __construct(private readonly SaveProductUseCase $saveProductUseCase)
    {
    }

    /**
     * Saves a product.
     *
     * @param Request $request the HTTP request object
     *
     * @return JsonResponse the JSON response indicating the status of the save operation
     *
     * @throws EntityNotFoundException
     */
    #[Route('/products/create', name: 'save_products', methods: ['POST'])]
    #[IsGranted('ROLE_ADD_PRODUCT')]
    public function save(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        var_dump($roles);
        $data = $request->toArray();
        $this->saveProductUseCase->execute($data);

        return $this->json(['message' => 'Product successfully created!']);
    }
}
