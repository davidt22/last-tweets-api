<?php

namespace App\Tests\Infrastructure\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShoutControllerTest extends WebTestCase
{
    public function testItReturnsLasTweetsSuccess()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/shout/realDonaldTrump', [
            'limit' => 1
        ]);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
    }

    public function testItReturnsErrorUserNotFoundResponse()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/shout/nothing', [
            'limit' => 1
        ]);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
    }

    public function testItReturnsErrorLimitTweetsResponse()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/shout/realDonaldTrump', [
            'limit' => 15
        ]);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $client->getResponse()->getStatusCode());
        $this->assertContains('Tweets are restricted to 10', $client->getResponse()->getContent());
    }
}