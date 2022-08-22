<?php

namespace src\oop\app\src\Encoder;

class Encoder
{
    /**
     * @param string $content
     * @param string $contentType
     * @return string
     */
    public function encode(string $content, string $contentType): string
    {
        preg_match('/charset=(.+)/', $contentType, $matches);

        if ($this->isUTF8($matches[1])) {
            return iconv($matches[1], mb_detect_encoding($content), $content);
        }

        return $content;
    }

    /**
     * @param $charset
     * @return bool
     */
    private function isUTF8($charset): bool
    {
        return mb_strtolower($charset) !== 'utf-8';
    }
}
