<?php

namespace strings;

class Strings implements StringsInterface
{
    /**
     * @param string $input
     * @return string
     */
    public function snakeCaseToCamelCase(string $input): string
    {
        $arrayInput = explode('_', $input);
        $camelCase = '';

        foreach ($arrayInput as $key => $string) {
            if ($key == 0) {
                $camelCase .= lcfirst($string);
            } else {
                $camelCase .= ucfirst($string);
            }
        }

        return $camelCase;
    }

    /**
     * @param string $input
     * @return string
     */
    public function mirrorMultibyteString(string $input): string
    {
        $arrayInput = explode(' ', mb_convert_encoding($input, "windows-1251", "UTF-8"));
        $reversed = [];

        foreach ($arrayInput as $str) {
            $reversed[] = strrev($str);
        }

        return mb_convert_encoding(implode(' ', $reversed), "UTF-8", "windows-1251");
    }

    /**
     * @param string $noun
     * @return string
     */
    public function getBrandName(string $noun): string
    {
        if (substr($noun, 0, 1) == substr($noun, -1, 1)) {
            return substr(ucfirst($noun),0,-1) . lcfirst($noun) ;
        }

        return "The " . ucfirst($noun);
    }
}