<?php

namespace Project;

use GuzzleHttp\Client as GuzzleClient;

class Requester
{
    /**
     * Platform base URL
     *
     * @var string
     */
    protected $url;

    /**
     * HTTP client instance
     *
     * @var GuzzleClient
     */
    protected $client;

    /**
     * Class constructor
     *
     * @param GuzzleClient $client
     * @param string $url
     */
    public function __construct(GuzzleClient $client, string $url)
    {
        $this->url = $url;
        $this->client = $client;
    }

    /**
     * Handle a request and prepare the response
     *
     * @param string $method
     * @param array|null $data
     * @return PageContent
     */
    public function request(string $method, array $data = null): PageContent
    {
        return new PageContent(
            (string) $this->client->request($method, $this->url, $data ?? [])
                ->getBody()
        );
    }
}
