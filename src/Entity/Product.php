<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Traits\ResourceId;

/**
 * Class Product
 * @package App\Entity
 * @ORM\Entity
 */
class Product
{

    use ResourceId;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Length(max=20)
     */
    private ?string $name = null;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $description = null;

    /**
     * @var int|null
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $quantity = null;

    /**
     * @var float|null
     * @ORM\Column(type="float")
     */
    private ?float $price = null;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeInterface $publishedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private User $producer;

    /**
     * @ORM\OneToMany(targetEntity=CartItem::class, mappedBy="product")
     */
    private $cartItems;

    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @param string $name
     * @param string $description
     * @param int $quantity
     * @param float $price
     * @param User $producer
     * @return static
     */
    public static function create(string $name, string $description, int $quantity, float $price, User $producer): self
    {
        $product = new self();
        $product->name = $name;
        $product->description = $description;
        $product->quantity = $quantity;
        $product->price = $price;
        $product->producer = $producer;
        return $product;
    }

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new \DateTimeImmutable();
        $this->cartItems = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $content
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPublishedAt(): \DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTimeInterface $publishedAt
     */
    public function setPublishedAt(\DateTimeInterface $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @param User $author
     */
    public function setProducer(User $producer): void
    {
        $this->producer = $producer;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setProduct($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getProduct() === $this) {
                $cartItem->setProduct(null);
            }
        }

        return $this;
    }
}
