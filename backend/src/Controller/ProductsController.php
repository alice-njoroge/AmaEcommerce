<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use App\useCases\SaveProductUseCase;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProductsController extends AbstractController
{
    private ProductRepository $productRepository;
    private SaveProductUseCase $saveProductUseCase;

    public function __construct(ProductRepository $productRepository, SaveProductUseCase $saveProductUseCase)
    {
        $this->productRepository = $productRepository;
        $this->saveProductUseCase = $saveProductUseCase;
    }

    #[Route('/products', name: 'app_products')]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);
    }

    /**
     * Saves a product.
     * @param Request $request The HTTP request object.
     * @return JsonResponse The JSON response indicating the status of the save operation.
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