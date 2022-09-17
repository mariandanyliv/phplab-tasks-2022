<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use src\oop\app\src\Encoder\Encoder;
use \GuzzleHttp\Exception\GuzzleException;

class GuzzleAdapter implements TransportInterface
{
    private Guzzle $adapter;

    private Encoder $encoder;

    public function __construct()
    {
        $this->adapter = new Guzzle();
        $this->encoder = new Encoder();
    }

    /**
     * @throws GuzzleException
     */
    public function getContent(string $url): string
    {
        $response = $this->request($url);

        return $this->encoder->encode(
            $response->getBody()->getContents(),
            $response->getHeader('content-type')[0]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function request(string $url): Response
    {
        return $this->adapter->request('GET', $url);
    }
}
