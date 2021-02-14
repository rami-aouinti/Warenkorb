<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartTest extends AbstractEndPoint
{
    /*
    private string $cartPayload = '{"product": 1, "quantity": 4}';


    public function testGetProducts(): void
    {
        $response = $this->testGetResponseFromRequest(Request::METHOD_GET, '/api/cart');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }


    public function testAddProduct(): void
    {
        $response = $this->testGetResponseFromRequest(Request::METHOD_POST, '/api/cart', $this->cartPayload);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
    */
}
