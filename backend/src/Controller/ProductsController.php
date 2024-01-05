<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

class ProductsController extends AbstractController
{
    private ProductRepository $productRepository;
    private ValidatorInterface $validator;

    public function __construct(ProductRepository $productRepository, ValidatorInterface $validator)
    {
        $this->productRepository = $productRepository;
        $this->validator = $validator;
    }

    #[Route('/products', name: 'app_products')]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);
    }

    #[Route('/products/create', name: 'save_products', methods: ['POST'])]
    public function save(Request $request, LoggerInterface $logger): JsonResponse
    {
        $data = $request->toArray();
        $imageURL = strtolower(str_replace(' ', '-', $data['name'])).'.jpg';

        $product = new Product();
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImageURL($imageURL);
        $product->setCreatedAt(new DateTimeImmutable('now'));
        $product->setStatus(true);

        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
           return $this->json($errors, 400);
        }
        $this->productRepository->save($product);

        return $this->json(['message' => 'Product successfully created!']);
    }
}