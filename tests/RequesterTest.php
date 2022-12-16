<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Project\Requester;

final class RequesterTest extends TestCase
{
    public function testHttpClient(): void
    {
        $client = new GuzzleClient([
            'handler' => HandlerStack::create(
                new MockHandler([
                    new Response(200, [], 'Simple Response'),
                ])
            ),
        ]);

        $requester = (new Requester($client, 'http://example.com'))
            ->request('GET');
        
        $this->assertEquals($requester->getResponseBody(), 'Simple Response');
    }
}
