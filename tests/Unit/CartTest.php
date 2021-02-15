<?php

namespace App\Tests\Unit;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class CartTest
 */
class CartTest extends TestCase
{
    private CartItem $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = new CartItem();
    }

    public function testGetQuantity(): void
    {
        $value = 5;
        $this->cart->setQuantity($value);
        $response = $this->cart;

        self::assertInstanceOf(CartItem::class, $response);
        self::assertEquals($value, $this->cart->getQuantity());
    }

    public function testGetProduct(): void
    {
        $value = new Product();
        $this->cart->setProduct($value);
        $response = $this->cart;

        self::assertInstanceOf(CartItem::class, $response);
        self::assertEquals($value, $this->cart->getProduct());
    }

    public function testGetCustomer(): void
    {
        $value = new User();
        $this->cart->setCustomer($value);
        $response = $this->cart;

        self::assertInstanceOf(CartItem::class, $response);
        self::assertEquals($value, $this->cart->getCustomer());
    }
}
