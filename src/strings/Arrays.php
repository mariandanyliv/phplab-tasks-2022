<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    public function repeatArrayValues(array $input): array
    {
        $result = [];
        foreach ($input as $elem) {
            for ($i = 0; $i < $elem; $i++) {
                $result[] = $elem;
            }
        }

        return $result;
    }

    public function getUniqueValue(array $input): int
    {
        $arrCount = array_count_values($input);
        $uniqArr = array_keys(array_filter($arrCount, function ($val) {
            return $val == 1;
        }));

        return !empty($uniqArr) ? min($uniqArr) : 0;
    }

    public function groupByTag(array $input): array
    {
        asort($input);
        $output = [];
        foreach ($input as $key => $val) {
            foreach ($val['tags'] as $tag) {
                $output[$tag][] = $val['name'];
            }
        }
        ksort($output);

        return $output;
    }

}
