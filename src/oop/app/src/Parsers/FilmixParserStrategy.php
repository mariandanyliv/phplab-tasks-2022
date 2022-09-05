<?php

namespace src\oop\app\src\Parsers;

class FilmixParserStrategy implements ParserInterface
{
    use ParserData;

    private const TITLE_PATTERN = '|<h1?.*>(.*)<\/h1>|';

    private const POSTER_PATTERN = '<.+src="([^"]+)".+itemprop="image".+>';

    private const DESCRIPTIONS_PATTERN = '|class="full-story">(.*?)<\/|';

    private string $content;

    public function parseContent(string $siteContent): self
    {
        $this->content = $siteContent;

        $this->title = $this->parsTitle();
        $this->poster = $this->parsPoster();
        $this->description = $this->parsDescriptions();

        return $this;
    }

    private function parsTitle()
    {
        preg_match_all(self::TITLE_PATTERN, $this->content, $matches);

        return $matches[1][0];
    }

    private function parsPoster()
    {
        preg_match_all(self::POSTER_PATTERN, $this->content, $matches);

        return (isset($matches[1][0])) ? $matches[1][0] : null;
    }

    private function parsDescriptions()
    {
        preg_match_all(self::DESCRIPTIONS_PATTERN, $this->content, $matches);

        return (isset($matches[1][0])) ? $matches[1][0] : null;
    }
}
