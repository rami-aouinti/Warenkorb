<?php

namespace App\Repository;

use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method CartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartItem[]    findAll()
 * @method CartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartItemRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager)
    {
        parent::__construct($registry, CartItem::class);
        $this->manager = $manager;
    }

    public function saveProduct($product, $quantity, $customer)
    {
        $newCart = new CartItem();

        $newCart
            ->setProduct($product)
            ->setQuantity($quantity)
            ->setCustomer($customer);

        $this->manager->persist($newCart);
        $this->manager->flush();
    }

    public function updateProduct(CartItem $cart): CartItem
    {
        $this->manager->persist($cart);
        $this->manager->flush();
    
        return $cart;
    }

    public function removeProduct(CartItem $cart)
    {
        $this->manager->remove($cart);
        $this->manager->flush();
    }
}
