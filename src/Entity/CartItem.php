<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Traits\ResourceId;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 */
class CartItem
{

    use ResourceId;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="cartItems",cascade={"persist"})
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(min=1)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cartItems")
     */
    private $customer;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'quantity' => $this->getQuantity()
        ];
    }
}
