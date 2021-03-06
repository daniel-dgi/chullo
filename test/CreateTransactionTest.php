<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Islandora\Chullo\Chullo;

class CreateTransactionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers  Islandora\Fedora\Chullo::createTransaction
     * @uses    GuzzleHttp\Client
     */
    public function testReturnsIdOn201() {
        $mock = new MockHandler([
            new Response(201, ['Location' => "http://localhost:8080/fcrepo/rest/tx:abc-123"]),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->createTransaction();
        $this->assertSame($result, "tx:abc-123");
    }
}
