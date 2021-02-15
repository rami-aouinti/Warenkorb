<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductTest
 */
class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function testGetName(): void
    {
        $value = 'Product name';
        $this->product->setName($value);
        $response = $this->product;

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getName());
    }

    public function testGetDescription(): void
    {
        $value = 'Product used to generate Shop Websites';
        $this->product->setDescription($value);
        $response = $this->product;

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getDescription());
    }

    public function testGetQuantity(): void
    {
        $value = 15;
        $this->product->setQuantity($value);
        $response = $this->product;

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getQuantity());
    }

    public function testGetPrice(): void
    {
        $value = 55.5;
        $this->product->setPrice($value);
        $response = $this->product;

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getPrice());
    }

    public function testGetProducer(): void
    {
        $value = new User();
        $this->product->setProducer($value);
        $response = $this->product;

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getProducer());
    }
}
