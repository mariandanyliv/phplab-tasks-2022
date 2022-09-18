<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    use ParserData;

    private const DOMAIN_PATTERN = '/^(?:http:\/\/|www\.|https:\/\/)([^\/]+)/';

    public function __construct(private Crawler $adapter)
    {

    }

    public function parseContent(string $siteContent): self
    {
        $this->adapter->addContent($siteContent);

        $this->title = $this->parsTitle('h1');
        $this->poster = $this->parsPoster('.fposter > a');
        $this->description = $this->parsDescription('#fdesc');

        return $this;
    }

    private function parsTitle(string $filter): string
    {
        return $this->adapter->filter($filter)->html();
    }

    private function parsPoster(string $filter): string
    {
        $imgSrc = $this->adapter->filter($filter)->filter('img')->attr('src');

        if (str_replace(['http://', 'https://', 'www.'], '', $imgSrc) === $imgSrc) {
            return $this->defineDomain($filter) . $imgSrc;
        }

        return $imgSrc;
    }

    private function parsDescription(string $filter): string
    {
        // Remove description title <h2>
        $this->adapter->filter($filter)->filter('h2')->each(function (Crawler $crawler) {
            foreach ($crawler as $node) {
                $node->parentNode->removeChild($node);
            }
        });

        return $this->adapter->filter($filter)->html();
    }

    private function defineDomain(string $filter): string
    {
        $link = $this->adapter->filter($filter)->attr('href');
        preg_match(self::DOMAIN_PATTERN, $link, $matches);

        return $matches[0];
    }
}
