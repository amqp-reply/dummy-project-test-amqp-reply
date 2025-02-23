<?php
declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QueryControllerTest extends WebTestCase
{
    public function testQueryReturnsValidResponse(): void
    {
        $client = self::createClient();

        $id = '123';
        $client->request('GET', "/query/{$id}");

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('ipServer', $decodedResponse);
    }

    public function testQueryWithInvalidId(): void
    {
        $client = self::createClient();

        $id = 'invalid-id';
        $client->request('GET', "/query/{$id}");

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('ipServer', $decodedResponse);
    }
}
