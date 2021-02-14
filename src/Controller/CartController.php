<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CartOperations;

/**
 * Class CartItemController
 * @package App\Controller
 * @Route("/cart")
 */
class CartController
{
    private CartItemRepository $cartRepository;

    private ProductRepository $productRepository;

    private EntityManagerInterface $entityManager;

    private CartOperations $cartOperations;

    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        CartItemRepository $cartRepository,
        ProductRepository $productRepository,
        CartOperations $cartOperations,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->cartOperations = $cartOperations;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
    * @Route(name="api_cart_collection_get", methods={"GET"})
    */
    public function getAll(): JsonResponse
    {
        $products = $this->cartRepository->findBy(
            [
                'customer' => $this->entityManager->getRepository(User::class)->findOneBy([])
            ]
        );
        
        $data = $this->cartOperations->getResource($products);
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

   /**
     * @Route(name="api_cart_collection_post", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = $this->productRepository->findOneBy(['id' => $data['product']]);
        ;
        $quantity = $data['quantity'];

        if (empty($product) || empty($quantity)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $productCart = $this->cartRepository->findOneBy(['product' => $product]);
    
        if ($productCart) {
            $quantity = min($product->getQuantity(), $quantity + $productCart->getQuantity());
            $productCart->setQuantity($quantity);
            $this->cartRepository->updateProduct($productCart);
        } else {
            $quantity = min($product->getQuantity(), $quantity);
            $this->cartRepository->saveProduct(
                $product,
                $quantity,
                $entityManager->getRepository(User::class)->findOneBy([])
            );
        }

        return new JsonResponse(['status' => 'Product created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_cart_item_put", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $cart = $this->cartRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
        $quantity = min($cart->getProduct()->getQuantity(), $data['quantity']);
        empty($data['quantity']) ? true : $cart->setQuantity($quantity);
        
        $updatedProduct = $this->cartRepository->updateProduct($cart);
    
        return new JsonResponse($updatedProduct->toArray(), Response::HTTP_OK);
    }
    
    /**
     * @Route("/{id}", name="api_cart_item_delete", methods={"DELETE"})
    */
    public function delete($id): JsonResponse
    {
        $product = $this->cartRepository->findOneBy(['id' => $id]);
    
        $this->cartRepository->removeProduct($product);
    
        return new JsonResponse(['status' => 'Product deleted'], Response::HTTP_NO_CONTENT);
    }
}
