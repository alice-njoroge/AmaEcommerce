<?php

namespace App\Controller;

use App\Enum\Groupings;
use App\Repository\ProductRepository;
use App\useCases\SaveProductUseCase;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/admin')]
class ProductManagementController extends AbstractController
{
    public function __construct(
        private readonly SaveProductUseCase $saveProductUseCase,
        private readonly ProductRepository $productRepository,
        private readonly NormalizerInterface $normalizer,
    ) {}

    /**
     * @throws ExceptionInterface
     */
    #[Route('/products', name: 'admin_get_products', methods: ['GET'])]
    #[IsGranted('ROLE_EDIT_PRODUCT')]
    public function index(): JsonResponse
    {
        $AllProducts = $this->productRepository->findAll();
        $products = [];
        foreach ($AllProducts as $product) {
            $products[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'quantity' => $product->getQuantity(),
                'imageURL' => $product->getImageURL(),
                'createdAt' => $product->getCreatedAt()->format('d,m,Y'),
                'updatedAt' => $product->getUpdatedAt() ? $product->getUpdatedAt()->format('d, M, Y') : null,
                'status' => $product->isStatus(),
                'price' => $product->getPrice(),
                'productCategory' => $product->getProductCategory(),
            ];
        }
        $products = $this->normalizer->normalize($products, 'json', ['groups' => Groupings::PRODUCT_MANAGEMENT]);

        return $this->json($products);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/products/{id}', name: 'admin_get_product', methods: ['GET'])]
    #[IsGranted('ROLE_EDIT_PRODUCT')]
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->NotFoundHttpException('Product not found');
        }

        $productData = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
            'imageURL' => $product->getImageURL(),
            'createdAt' => $product->getCreatedAt()->format('d,m,Y'),
            'updatedAt' => $product->getUpdatedAt() ? $product->getUpdatedAt()->format('d, M, Y') : null,
            'status' => $product->isStatus(),
            'price' => $product->getPrice(),
            'productCategory' => $product->getProductCategory(),
        ];

        $productData = $this->normalizer->normalize($productData, 'json', ['groups' => Groupings::PRODUCT_MANAGEMENT]);

        return $this->json($productData);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/products/{id}', name: 'update_product', methods: ['PUT'])]
    #[IsGranted('ROLE_EDIT_PRODUCT')]
    public function update(Request $request, int $id): JsonResponse
    {

        $data = $request->toArray();
        $this->saveProductUseCase->execute($data, $id);

        return $this->json(['message' => 'Product successfully updated!']);
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
