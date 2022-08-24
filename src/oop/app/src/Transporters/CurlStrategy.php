<?php

namespace src\oop\app\src\Transporters;

use CurlHandle;
use src\oop\app\src\Encoder\Encoder;

class CurlStrategy implements TransportInterface
{
    private CurlHandle $ch;

    private Encoder $encoder;

    private array $options = [
        CURLOPT_HEADER          => true,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_RETURNTRANSFER  => true,
    ];

    private string $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:50.0) Gecko/20100101 Firefox/90.0';
    private array $httpHeader = [
        'Content-Type: text/html; charset=windows-1251',
    ];

    public function __construct()
    {
        $this->encoder = new Encoder();
    }

    public function getContent(string $url): string
    {
        $this->curlInit($url);
        $dom = $this->encoder->encode($this->getDom(), curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE));
        $this->curlClose();

        return $dom;
    }

    private function curlInit(string $url): void
    {
        $ch = curl_init();

        curl_setopt_array($ch, $this->options);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeader);

        $this->ch = $ch;
    }

    /**
     * @return string
     */
    private function getDom(): string
    {
        return curl_exec($this->ch);
    }

    /**
     * @return void
     */
    private function curlClose(): void
    {
        curl_close($this->ch);
    }
}
