<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Islandora\Chullo\Chullo;

class GetResourceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers  Islandora\Fedora\Chullo::getResource
     * @uses    GuzzleHttp\Client
     */
    public function testReturnsContentOn200() {
        $mock = new MockHandler([
            new Response(200, [], "SOME CONTENT"),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->getResource("");
        $this->assertSame((string)$result, "SOME CONTENT");
    }

    /**
     * @covers  Islandora\Fedora\Chullo::getResource
     * @uses    GuzzleHttp\Client
     */
    public function testReturnsNullOn304() {
        $mock = new MockHandler([
            new Response(304),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->getResource("");
        $this->assertNull($result);
    }

    /**
     * @covers            Islandora\Fedora\Chullo::getResource
     * @uses              GuzzleHttp\Client
     * @expectedException GuzzleHttp\Exception\ClientException
     */
    public function testThrowsExceptionOn404() {
        $mock = new MockHandler([
            new Response(404),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->getResource("");
    }
}
