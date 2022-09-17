<?php

namespace src\oop\app\src\Parsers;

trait ParserData
{
    private string $title;

    private string $poster;

    private string $description;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'poster'      => $this->poster,
            'description' => $this->description,
        ];
    }
}