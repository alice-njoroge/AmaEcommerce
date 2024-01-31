<?php

namespace App\Controller;

use App\Enum\Groupings;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductsController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/products', name: 'app_products')]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        $products = $this->normalizer->normalize($products, 'json', ['groups' => Groupings::PRODUCT_SHOPPING]);

        return $this->json($products);
    }
}
