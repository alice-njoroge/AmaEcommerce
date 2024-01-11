<?php

namespace App\Controller;

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
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/products/create', name: 'save_products', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $this->saveProductUseCase->execute($data);

        return $this->json(['message' => 'Product successfully created!']);
    }
}