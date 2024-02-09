<?php

namespace App\useCases;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveProductUseCase
{
    private ValidatorInterface $validator;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->productRepository = $productRepository;
    }

    /**
     * @param mixed $data
     *
     * @throws EntityNotFoundException
     */
    public function execute(array $data, string $id): Product
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->NotFoundHttpException('Product not found');
        }

        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImageURL($data['imageURL']);
        $product->setUpdatedAt(new \DateTimeImmutable('now'));
        $product->setStatus($data['status']);

        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
            throw new EntityNotFoundException('Learn How to deal with these exceptions');
        }

        return $this->productRepository->save($product);
    }
}
