<?php

namespace Project;

use GuzzleHttp\Client as GuzzleClient;

class RemoteServer
{
    /**
     * Characters to replace
     *
     * @var array
     */
    public const REPLACE = [
        'a' => "\x7a",
        'b' => "\x79",
        'c' => "\x78",
        'd' => "\x77",
        'e' => "\x76",
        'f' => "\x75",
        'g' => "\x74",
        'h' => "\x73",
        'i' => "\x72",
        'j' => "\x71",
        'k' => "\x70",
        'l' => "\x6f",
        'm' => "\x6e",
        'n' => "\x6d",
        'o' => "\x6c",
        'p' => "\x6b",
        'q' => "\x6a",
        'r' => "\x69",
        's' => "\x68",
        't' => "\x67",
        'u' => "\x66",
        'v' => "\x65",
        'w' => "\x64",
        'x' => "\x63",
        'y' => "\x62",
        'z' => "\x61",
        '0' => "\x39",
        '1' => "\x38",
        '2' => "\x37",
        '3' => "\x36",
        '4' => "\x35",
        '5' => "\x34",
        '6' => "\x33",
        '7' => "\x32",
        '8' => "\x31",
        '9' => "\x30",
    ];

    /**
     * Platform URL
     *
     * @var string
     */
    protected $url;

    /**
     * HTTP client
     *
     * @var GuzzleClient
     */
    protected $client;

    /**
     * Class constructor
     *
     * @param string $url
     * @param GuzzleClient $client
     */
    public function __construct(string $url, GuzzleClient $client = null)
    {
        $this->url = $url;
        $this->client = $client ?? $this->initializeHttpClient();
    }

    /**
     * Initialize a new HTTP client instance
     *
     * @return GuzzleClient
     */
    public function initializeHttpClient(): GuzzleClient
    {
        return new GuzzleClient([
            'cookies' => true,
        ]);
    }

    /**
     * Handle HTTP request and return response
     *
     * @param string $method
     * @param array|null $data
     * @return PageContent
     */
    protected function request(string $method, array $data = null): PageContent
    {
        return (new Requester($this->client, $this->url))
            ->request($method, $data);
    }

    public function getToken(): string
    {
        $token = str_split($this->request('GET')->getToken());

        foreach ($token as $index => $character) {
            $token[$index] = self::REPLACE[$character] ?? $character;
        }

        return implode('', $token);
    }

    public function getAnswer(): string
    {
        $requestResponse = $this->request('POST', [
            'form_params' => [
                'token' => $this->getToken(),
            ],

            'headers' => [
                'Referer' => rtrim($this->url, '/') . '/',
            ]
        ]);


        return $requestResponse->getAnswer();
    }
}
