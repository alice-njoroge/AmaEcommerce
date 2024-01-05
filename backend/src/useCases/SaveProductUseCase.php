<?php

namespace App\useCases;

use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTimeImmutable;
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
     * @throws EntityNotFoundException
     */
    public function execute($data): Product
    {
        $imageURL = strtolower(str_replace(' ', '-', $data['name'])) . '.jpg';

        $product = new Product();
        $product->setName($data['name']);
        $product->setQuantity($data['quantity']);
        $product->setPrice($data['price']);
        $product->setImageURL($imageURL);
        $product->setCreatedAt(new DateTimeImmutable('now'));
        $product->setStatus(true);

        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
           throw new EntityNotFoundException("Learn How to deal with these exceptions");
        }
        return $this->productRepository->save($product);

    }


}