<?php

namespace App\Services;

/**
 * Class CartOperations
 */
class CartOperations
{
    public function getResource(array $products)
    {
        $data = [];
        $somme = 0;
        foreach ($products as $product) {
            $data["products"][] = [
                    'id' => $product->getId(),
                    'product' => $product->getProduct()->getName(),
                    'quantity' => $product->getQuantity(),
                    'price' => $product->getProduct()->getPrice(),
                    'priceSum' => $product->getProduct()->getPrice() * $product->getQuantity()
            ];
            $somme = $somme + $product->getProduct()->getPrice() * $product->getQuantity();
        }
        $data['somme'] = $somme;
        return ($data);
    }
}
