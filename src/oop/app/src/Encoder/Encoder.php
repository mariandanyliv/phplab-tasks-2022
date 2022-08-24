<?php

namespace src\oop\app\src\Encoder;

class Encoder
{
    private const PATTERN = '/charset=(.+)/';

    public function encode(string $content, string $contentType): string
    {
        preg_match(self::PATTERN, $contentType, $matches);

        if ($this->isUTF8(isset($matches[1]))) {
            return iconv($matches[1], mb_detect_encoding($content), $content);
        }

        return $content;
    }

    private function isUTF8(string $charset): bool
    {
        return mb_strtolower($charset) !== 'utf-8';
    }
}
