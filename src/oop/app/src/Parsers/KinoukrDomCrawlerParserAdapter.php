<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    use ParserData;

    private Crawler $adapter;

    public function __construct()
    {
        $this->adapter = new Crawler();
    }

    /**
     * @param string $siteContent
     * @return $this
     */
    public function parseContent(string $siteContent): self
    {
        $this->adapter->addContent($siteContent);

        $this->title = $this->parsTitle('h1');
        $this->poster = $this->parsPoster('.fposter > a');
        $this->description = $this->parsDescription('#fdesc');

        return $this;
    }

    /**
     * @param string $filter
     * @return string
     */
    private function parsTitle(string $filter): string
    {
        return $this->adapter->filter($filter)->html();
    }

    /**
     * @param string $filter
     * @return string
     */
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

    /**
     * Use this method if img href returns without domain
     * @param string $filter
     * @return string
     */
    private function defineDomain(string $filter): string
    {
        $link = $this->adapter->filter($filter)->attr('href');
        preg_match('/^(?:http:\/\/|www\.|https:\/\/)([^\/]+)/', $link, $matches);

        return $matches[0];
    }
}
