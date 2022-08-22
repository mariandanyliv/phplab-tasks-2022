<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use src\oop\app\src\Encoder\Encoder;

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
     * @param string $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @param string $url
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url): Response
    {
        return $this->adapter->request('GET', $url);
    }
}
