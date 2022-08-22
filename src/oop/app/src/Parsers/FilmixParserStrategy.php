<?php

namespace src\oop\app\src\Parsers;

class FilmixParserStrategy implements ParserInterface
{
    use ParserData;

    private string $content;

    /**
     * @param string $siteContent
     * @return $this
     */
    public function parseContent(string $siteContent): self
    {
        $this->content = $siteContent;

        $this->title = $this->parsTitle();
        $this->poster = $this->parsPoster();
        $this->description = $this->parsDescriptions();

        return $this;
    }

    /**
     * @return string
     */
    private function parsTitle(): string
    {
        preg_match_all('|<h1?.*>(.*)<\/h1>|', $this->content, $matches);

        return $matches[1][0];
    }

    /**
     * @return string
     */
    private function parsPoster(): string
    {
        preg_match_all('<.+src="([^"]+)".+itemprop="image".+>', $this->content, $matches);

        return $matches[1][0];
    }

    /**
     * @return string
     */
    private function parsDescriptions(): string
    {
        preg_match_all('|class="full-story">(.*?)<\/|', $this->content, $matches);

        return $matches[1][0];
    }
}
