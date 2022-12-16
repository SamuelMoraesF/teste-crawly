<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Project\RemoteServer;

final class RemoteServerTest extends TestCase
{
    public function testInitializeHttpClient(): void
    {
        $remote = new RemoteServer('http://example.com');
        $this->assertInstanceOf(GuzzleHttp\Client::class, $remote->initializeHttpClient());
    }

    public function testGetToken(): void
    {
        $client = new GuzzleClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], 'Content <input id="token" value="1234567890">'),
                ])
            ),
        ]);

        $remote = new RemoteServer('http://example.com', $client);
        $this->assertEquals('8765432109', $remote->getToken());
    }

    public function testGetAnswer(): void
    {
        $client = new GuzzleClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], 'Content <input id="token" value="1234567890">'),
                    new Response(200, [], 'Content <span id="answer">123</span>'),
                ])
            ),
        ]);

        $remote = new RemoteServer('http://example.com', $client);
        $this->assertEquals('123', $remote->getAnswer());
    }
}
