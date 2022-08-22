<?php
/**
 * Create Class - Scrapper with method getMovie().
 * getMovie() - should return Movie Class object.
 *
 * Note: Use next namespace for Scrapper Class - "namespace src\oop\app\src;"
 * Note: Dont forget to create variables for TransportInterface and ParserInterface objects.
 * Note: Also you can add your methods if needed.
 */

namespace src\oop\app\src;

use src\oop\app\src\Models\Movie;
use src\oop\app\src\Models\MovieInterface;
use src\oop\app\src\Parsers\ParserInterface;
use src\oop\app\src\Transporters\TransportInterface;

class Scrapper
{
    private TransportInterface $transport;
    private ParserInterface $parser;

    /**
     * @param TransportInterface $transport
     * @param ParserInterface $parser
     */
    public function __construct(TransportInterface $transport, ParserInterface $parser)
    {
        $this->transport = $transport;
        $this->parser = $parser;
    }

    /**
     * @param string $uri
     * @return MovieInterface
     */
    public function getMovie(string $uri): MovieInterface
    {
        $dom = $this->transport->getContent($uri);

        return new Movie($this->parser->parseContent($dom)->toArray());
    }
}
